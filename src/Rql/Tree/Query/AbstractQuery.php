<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 4/22/15
 * Time: 9:24 AM
 */

namespace Rql\Tree\Query;

use Rql\Client;
use Rql\Cursor;
use Rql\Def\Response\ResponseType;
use Rql\Tree\Datum\TypeResolver;
use Rql\Tree\Leaf;
use Rql\Tree\Query\Db\Db;
use Rql\Tree\Request\Start;

abstract class AbstractQuery extends Leaf
{
    /**
     * @var AbstractQuery[]
     */
    protected $terms = [];

    /**
     * @var AbstractQuery[]
     */
    protected $options = [];

    public function build()
    {
        $finalTerms = [];
        foreach($this->terms as $term) {
            $finalTerms[] = $term->build();
        }

        $finalOptions = [];
        foreach($this->options as $key => $option) {
            $finalOptions[$key] = $option->build();
        }

        $ast = [$this->getDefinition(), $finalTerms];
        if($finalOptions) {
            $ast[2] = (object) $finalOptions;
        }

        return $ast;
    }

    /**
     * @param Client $conn
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function run(Client $conn, array $options = [])
    {
        $globalOptions = [];
        if($options) {
            foreach ($options as $key => $option) {
                if($key == 'db') {
                    $globalOptions[$key] = (new Db(TypeResolver::make($option)))->build();
                    continue;
                }

                $globalOptions[$key] = $option;
            }
        }

        $request = new Start($this, $globalOptions);
        $response = $conn->send($request);

        switch($response['data']['t']) {
            case ResponseType::SUCCESS_PARTIAL:
            case ResponseType::SUCCESS_SEQUENCE:
                return new Cursor($response, $conn);
                break;
        }

        return $response['data']['r'][0];
    }
}
