<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 5:05 PM
 */

namespace Rql\Tree\Datum;

use Rql\Def\Term\TermType;

class Float extends AbstractDatum
{
    /**
     * @param float $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function build()
    {
        return (float) $this->value;
    }

    protected function getDefinition()
    {
        return TermType::DATUM;
    }
}
