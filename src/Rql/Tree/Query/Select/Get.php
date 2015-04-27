<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/26/15
 * Time: 7:22 PM
 */

namespace Rql\Tree\Query\Select;

use Rql\Def\Term\TermType;
use Rql\Tree\Datum\TypeResolver;
use Rql\Tree\Query\AbstractQuery;
use Rql\Tree\Query\Table\Table;

class Get extends AbstractQuery
{
    public function __construct(Table $table, $key)
    {
        $this->terms[] = $table;
        $this->terms[] = TypeResolver::make($key);
    }

    public function getDefinition()
    {
        return TermType::GET;
    }
}
