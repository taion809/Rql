<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/26/15
 * Time: 7:47 AM
 */

namespace Rql;

use Rql\Def\Response\ResponseType;
use Rql\Tree\Request\Stop;

class Cursor implements \Iterator
{
    /**
     * Token from initial Start query
     *
     * @var string
     */
    protected $token;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var bool
     */
    protected $isComplete = false;

    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @var int
     */
    protected $size = 0;

    /**
     * @param array $data
     * @param Client $client
     */
    public function __construct(array $data, Client $client)
    {
        $this->client = $client;

        $this->parseResponse($data);
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        if(! $this->isComplete) {
            $stop = new Stop();
            $this->send($stop, $this->token);

            $this->isComplete = true;
        }

        $this->data = [];
        $this->index = 0;
        $this->size = 0;
    }

    public function current()
    {
        $this->fetchNext();
        return $this->data[$this->index];
    }

    public function next()
    {
        $this->fetchNext();

        if(! $this->valid()) {
            $this->close();
        }

        $this->index++;
    }

    public function valid()
    {
        $this->fetchNext();

        return ! $this->isComplete || $this->hasNext();
    }

    protected function hasNext() {
        return (bool) ($this->index < $this->size);
    }

    protected function fetchNext()
    {
        if($this->index == $this->size) {
            if($this->isComplete) {
                return;
            }

            $query = new Tree\Request\SequenceContinue();
            $response = $this->send($query);

            $this->parseResponse($response);
        }
    }

    private function send($request)
    {
        try {
            $response = $this->client->send($request, $this->token);
        } catch(\Exception $e) {
            $this->client->getConnection()->close();
            throw $e;
        }

        return $response;
    }
    protected function parseResponse($response)
    {
        $this->isComplete = $response['data']['t'] == ResponseType::SUCCESS_SEQUENCE;
        $this->data = $response['data']['r'];
        $this->index = 0;
        $this->size = count($response['data']['r']);
        $this->token = $response['headers']['token'];
    }

    // Implemented to satisfy \Iterator
    public function key() { return null; }

    // Implemented to satisfy \Iterator
    public function rewind() { return; }
}
