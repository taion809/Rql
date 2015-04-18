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

    public function connect()
    {

    }

    private function sendHandshake()
    {
        
    }
}
