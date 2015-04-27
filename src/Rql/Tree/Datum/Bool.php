<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 5:05 PM
 */

namespace Rql\Tree\Datum;

use Rql\Def\Term\TermType;

class Bool extends AbstractDatum
{
    /**
     * @param bool $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function build()
    {
        return (bool) $this->value;
    }

    protected function getDefinition()
    {
        return TermType::DATUM;
    }
}
