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
use Rql\Def\Response\ResponseType;
use Rql\Def\VersionDummy\Protocol;
use Rql\Def\VersionDummy\Version;

/**
 * Class StreamConnection
 * @package Rql\Connection
 */
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
     * @var int
     */
    protected $token;

    /**
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->connected = false;
        $this->stream = $stream;
        $this->token = 0;
    }

    /**
     * @param array $connect
     * @return static
     */
    public static function make(array $connect)
    {
        $r = [
            'schema' => isset($connect['schema']) ? $connect['schema'] : 'tcp',
            'host' => isset($connect['host']) ? $connect['host'] : 'localhost',
            'port' => isset($connect['port']) ? $connect['port'] : '28015',
            'options' => isset($connect['options']) ? $connect['options'] : []
        ];

        $connectString = sprintf("%s://%s:%s", $r['schema'], $r['host'], $r['port']);
        $resource = stream_socket_client($connectString, $errno, $errstr);

        $stream = Stream::factory($resource, $r['options']);
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

    /**
     * @return array|mixed|null
     */
    public function getMetadata()
    {
        if(! $this->connected) {
            return [];
        }
        return $this->stream->getMetadata();
    }

    /**
     * @param $data
     * @param int $token
     * @return array
     * @throws \Exception
     */
    public function send($data, $token = -1)
    {
        if(! $this->isConnected()) {
            $this->connect();
        }

        if($token < 0) {
            $token = $this->nextToken();
        }

        $this->write($this->encode($data, $token));

        $headers = $this->fetchHeaders();
        $responseSize = $this->parseHeaders($headers, $token);
        $response = $this->fetchResponse($responseSize);

        return [
            'metadata' => $this->getMetadata(),
            'headers' => $headers,
            'data' => $response
        ];
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

    /**
     * @param $numBytes
     * @return string
     * @throws \Exception
     */
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

    /**
     * @return bool
     * @throws \Exception
     */
    protected function sendHandshake()
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

    /**
     * @return array
     * @throws \Exception
     */
    protected function fetchHeaders()
    {
        $rawHeaders = $this->read(12);
        $headers = unpack('Vtoken/Vtoken2/Vsize', $rawHeaders);

        return $headers;
    }

    /**
     * @param $headers
     * @param $token
     * @return int
     * @throws \Exception
     */
    protected function parseHeaders($headers, $token)
    {
        if($headers['token2'] !== 0) {
            throw new \Exception("Invalid response from server");
        }
        if($headers['token'] !== $token) {
            throw new \Exception("Response token mismatch: received [{$headers['token']}]");
        }
        return (int) $headers['size'];
    }

    /**
     * @param $size
     * @return mixed
     * @throws \Exception
     */
    protected function fetchResponse($size)
    {
        $rawResponse = $this->read($size);
        $response = json_decode($rawResponse, true);

        switch($response['t']) {
            case ResponseType::CLIENT_ERROR:
                throw new \Exception($response['r'][0], ResponseType::CLIENT_ERROR);
            case ResponseType::COMPILE_ERROR:
                throw new \Exception($response['r'][0], ResponseType::COMPILE_ERROR);
            case ResponseType::RUNTIME_ERROR:
                throw new \Exception($response['r'][0], ResponseType::RUNTIME_ERROR);
        }

        return $response;
    }

    /**
     * @param $data
     * @param $token
     * @return string
     */
    protected function encode($data, $token)
    {
        $json = json_encode($data);
        $size = pack('V', strlen($json));
        $binToken = pack('V', $token) . pack('V', 0);
        return $binToken . $size . $json;
    }

    /**
     * @return int
     */
    protected function nextToken()
    {
        return mt_rand(100, 100000);
    }
}
