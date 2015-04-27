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

class GetAll extends AbstractQuery
{
    public function __construct(Table $table, $key, array $args = [])
    {
        $this->terms[] = $table;

        if(is_array($key)) {
            foreach($key as $value) {
                $this->terms[] = TypeResolver::make($value);
            }
        } else {
            $this->terms[] = TypeResolver::make($key);
        }

        foreach($args as $key => $value) {
            $this->options[$key] = $value;
        }
    }

    public function getDefinition()
    {
        return TermType::GET_ALL;
    }
}
