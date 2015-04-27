<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:40 AM
 */

namespace Rql\Tree\Request;

use Rql\Def\Query\QueryType;
use Rql\Tree\Leaf;

class Stop extends Leaf implements \JsonSerializable
{
    public function build() {
        return [$this->getDefinition()];
    }

    public function getDefinition()
    {
        return QueryType::STOP;
    }

    public function jsonSerialize()
    {
        return $this->build();
    }
}
