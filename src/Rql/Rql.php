<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/21/15
 * Time: 11:29 PM
 */

namespace Rql;
use Rql\Tree\Query\Db\Db;
use Rql\Tree\Datum\TypeResolver;
use Rql\Tree\Query\Table\Table;

/**
 * Class Rql
 * @package Rql
 */
class Rql
{
    /**
     * @param array $connect
     * @return Client
     */
    public static function connect(array $connect)
    {
        $r = [
            'schema' => isset($connect['schema']) ? $connect['schema'] : 'tcp',
            'host' => isset($connect['host']) ? $connect['host'] : 'localhost',
            'port' => isset($connect['port']) ? $connect['port'] : '28015',
            'options' => isset($connect['options']) ?: []
        ];

        return new Client(Connection\StreamConnection::make($r));
    }

    /**
     * @param $name
     * @return Db
     */
    public function Db($name)
    {
        return new Db(TypeResolver::make($name));
    }

    public function Table($name)
    {
        return new Table(TypeResolver::make($name));
    }
}
