<?php
namespace Rql\Def\Datum;

/**
 * Class DatumType
 * @package Rql\Def\Datum
 */
class DatumType
{
    const R_NULL = 1;
    const R_BOOL = 2;
    const R_NUM = 3;
    const R_STR = 4;
    const R_ARRAY = 5;
    const R_OBJECT = 6;

    /**
    * This [DatumType] will only be used if [accepts_r_json] is
    * set to [true] in [Query].  [r_str] will be filled with a
    * JSON encoding of the [Datum].
    */
    const R_JSON = 7;
}
