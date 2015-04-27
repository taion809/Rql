<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 5:02 PM
 */

namespace Rql\Tree\Datum;

class TypeResolver
{
    public static function make($data)
    {
        if(is_null($data)) {
            return new Null();
        } elseif(is_bool($data)) {
            return new Bool($data);
        } elseif(is_float($data)) {
            return new Float($data);
        } elseif(is_int($data)) {
            return new Integer($data);
        } elseif(is_string($data)) {
            return new String($data);
        }

        return null;
    }

    public static function force($data, $type)
    {
        switch(strtolower($type)) {
            case 'json':
                return new Json($data);
        }
    }

    private function isJson($data)
    {
        return preg_match("/[^,:{}\\[\\]0-9.\\-+Eaeflnr-u \\n\\r\\t]/", (string) $data);
    }
}
