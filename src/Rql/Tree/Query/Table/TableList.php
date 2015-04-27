<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:15 AM
 */

namespace Rql\Tree\Query\Table;

use Rql\Def\Term\TermType;
use Rql\Tree\Query\AbstractQuery;

class TableList extends AbstractQuery
{
    public function __construct($name)
    {
        $this->terms[] = $name;
    }

    public function getDefinition()
    {
        return TermType::TABLE_LIST;
    }
}
