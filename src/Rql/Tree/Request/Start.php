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

class Start extends Leaf implements \JsonSerializable
{
    /**
     * @var Leaf
     */
    protected $terms;

    protected $options;

    public function __construct(Leaf $terms, array $options = []) {
        $this->terms = $terms;
        $this->options = $options;
    }

    public function build() {
        return [$this->getDefinition(), $this->terms->build(), (object) $this->options];
    }

    public function getDefinition()
    {
        return QueryType::START;
    }

    public function jsonSerialize()
    {
        return $this->build();
    }
}
