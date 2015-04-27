<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:15 AM
 */

namespace Rql\Tree\Query\Table;

use Rql\Def\Term\TermType;
use Rql\Tree\Datum\TypeResolver;
use Rql\Tree\Query\AbstractQuery;
use Rql\Tree\Query\Control\Json;
use Rql\Tree\Query\Write\Insert;

class Table extends AbstractQuery
{
    public function __construct($name, $db = null)
    {
        if($db) {
            $this->terms[] = $db;
        }

        $this->terms[] = $name;
    }

    public function getDefinition()
    {
        return TermType::TABLE;
    }

    public function limit($num)
    {
        $num = TypeResolver::make((int) $num);

        return new Limit($this, $num);
    }

    public function insert($data)
    {
        $data = TypeResolver::force($data, 'json');

        return new Insert($this, new Json($data));
    }
}
