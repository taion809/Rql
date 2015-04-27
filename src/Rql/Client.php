<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:57 AM
 */

namespace Rql;

use Rql\Def\Response\ResponseType;

class Client
{
    /**
     * @var Connection\StreamConnection
     */
    private $connection;

    /**
     * @param Connection\StreamConnection $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection\StreamConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param $query
     * @param int $token
     * @return mixed
     * @throws \Exception
     */
    public function send($query, $token = -1)
    {
        try {
            $response = $this->connection->send($query, $token);
        } catch(\Exception $e) {
            $this->connection->close();
            throw $e;
        }

        return $response;
    }
}
