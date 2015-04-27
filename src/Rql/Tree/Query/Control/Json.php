<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:15 AM
 */

namespace Rql\Tree\Query\Control;

use Rql\Def\Term\TermType;
use Rql\Tree\Query\AbstractQuery;

class Json extends AbstractQuery
{
    public function __construct($terms)
    {
        $this->terms[] = $terms;
    }

    public function getDefinition()
    {
        return TermType::JSON;
    }
}
