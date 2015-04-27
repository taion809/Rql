<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 5:05 PM
 */

namespace Rql\Tree\Datum;

use Rql\Def\Term\TermType;

class Integer extends AbstractDatum
{
    /**
     * @param int $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function build()
    {
        return (int) $this->value;
    }

    protected function getDefinition()
    {
        return TermType::DATUM;
    }
}
