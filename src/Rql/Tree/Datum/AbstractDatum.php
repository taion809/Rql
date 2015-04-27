<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/23/15
 * Time: 9:02 AM
 */

namespace Rql\Tree\Datum;

use Rql\Tree\Leaf;

abstract class AbstractDatum extends Leaf
{
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
