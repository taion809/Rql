<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 5:05 PM
 */

namespace Rql\Tree\Datum;

use Rql\Def\Term\TermType;

class Null extends AbstractDatum
{
    public function __construct()
    {
        $this->value = null;
    }

    public function build()
    {
        return null;
    }

    protected function getDefinition()
    {
        return TermType::DATUM;
    }
}
