<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/26/15
 * Time: 9:45 AM
 */

namespace Rql\Tree\Request;

use Rql\Def\Query\QueryType;
use Rql\Tree\Leaf;

class SequenceContinue extends Leaf implements \JsonSerializable
{
    public function build() {
        return [$this->getDefinition()];
    }

    public function getDefinition()
    {
        return QueryType::R_CONTINUE;
    }

    public function jsonSerialize()
    {
        return $this->build();
    }
}
