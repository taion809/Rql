<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:15 AM
 */

namespace Rql\Tree\Query\Write;

use Rql\Def\Term\TermType;
use Rql\Tree\Query\AbstractQuery;

class Insert extends AbstractQuery
{
    public function __construct($terms, $json)
    {
        $this->terms[] = $terms;
        $this->terms[] = $json;
    }

    public function getDefinition()
    {
        return TermType::INSERT;
    }
}
