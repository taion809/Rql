<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:15 AM
 */

namespace Rql\Tree\Query;

use Rql\Def\Term\TermType;

class Limit extends AbstractQuery
{
    public function __construct($leaf, $num)
    {
        $this->terms[] = $leaf;
        $this->terms[] = $num;
    }

    public function getDefinition()
    {
        return TermType::LIMIT;
    }
}
