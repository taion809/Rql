<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/17/15
 * Time: 11:23 PM
 */

namespace Rql\Connection;

use GuzzleHttp\Stream\NoSeekStream;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Stream\StreamInterface;
use Rql\Def\VersionDummy\Protocol;
use Rql\Def\VersionDummy\Version;

class StreamConnection
{
    /**
     * @var bool
     */
    protected $connected;

    /**
     * @var StreamInterface
     */
    protected $stream;

    /**
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->connected = false;
        $this->stream = $stream;
    }

    /**
     * @param $resource
     * @param array $options
     * @return static
     */
    public static function make($resource, $options = [])
    {
        $stream = Stream::factory($resource, $options);
        return new static(new NoSeekStream($stream));
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->connected;
    }

    /**
     * @throws \Exception
     */
    public function connect()
    {
        if(! $this->connected) {
            $this->sendHandshake();
        }

        $this->connected = true;
    }

    public function close()
    {
        $this->stream->close();
    }

    public function getMetadata()
    {
        if(! $this->connected) {
            return [];
        }
        return $this->stream->getMetadata();
    }

    /**
     * @param $message
     * @return bool|int
     * @throws \Exception
     */
    private function write($message)
    {
        $totalBytesWritten = 0;
        while($totalBytesWritten < strlen($message)) {
            $bytesWritten = $this->stream->write($message);
            if($bytesWritten === false || $bytesWritten === 0) {
                $this->stream->close();
                throw new \Exception("Unable to write to stream");
            }

            $totalBytesWritten += $bytesWritten;
        }

        return $totalBytesWritten;
    }

    private function read($numBytes)
    {
        $response = '';
        while (strlen($response) < $numBytes) {
            $partialResponse = $this->stream->read($numBytes);
            if ($partialResponse === false) {
                $metadata = $this->stream->getMetadata();
                $this->close();

                if (isset($metadata['timed_out']) && $metadata['timed_out']) {
                    throw new \Exception("Reading from stream timed out");
                }

                throw new \Exception("Unable to read from stream");
            }

            $response .= $partialResponse;
        }

        return $response;
    }

    private function sendHandshake()
    {
        $binaryVersion = pack("V", Version::V0_4);
        $handshake = $binaryVersion;
        $binaryKeyLength = pack("V", 0);
        $handshake .= $binaryKeyLength . "";
        $binaryProtocol = pack("V", Protocol::JSON);
        $handshake .= $binaryProtocol;

        try {
            $this->write($handshake);
        } catch(\Exception $e) {
            $this->close();
            throw new \Exception('Handshake failed.', 0, $e);
        }

        // Read SUCCESS\000 from stream.
        $response = '';
        while(true) {
            try {
                $r = $this->read(1);
            } catch(\Exception $e) {
                $this->close();
                throw new \Exception('Handshake failed.', 0, $e);
            }

            if($r == chr(0)) {
                break;
            }

            $response .= $r;
        }

        if($response !== 'SUCCESS') {
            throw new \Exception('Handshake failed.');
        }

        return true;
    }
}
