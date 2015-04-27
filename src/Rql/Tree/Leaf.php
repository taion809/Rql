<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/23/15
 * Time: 8:58 AM
 */

namespace Rql\Tree;

abstract class Leaf
{
    abstract protected function build();
    abstract protected function getDefinition();
}
