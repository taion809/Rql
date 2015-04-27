<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:15 AM
 */

namespace Rql\Tree\Query\Db;

use Rql\Def\Term\TermType;
use Rql\Tree\Query\AbstractQuery;

class DbDrop extends AbstractQuery
{
    public function __construct($name)
    {
        $this->terms[] = $name;
    }

    public function getDefinition()
    {
        return TermType::DB_DROP;
    }
}
