<?php
/**
 * Created by PhpStorm.
 * User: shisiying
 * Date: 2019-07-06
 * Time: 17:57
 */

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request,$builder;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return mixed|void
     */
    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $filter=>$value) {
            if(method_exists($this,$filter)){  // 注：此处是 hasFilter() 方法的重构
                $this->$filter($value);
            }
        }

        return $this->builder;
    }


    protected function getFilters()
    {
        return $this->request->intersect($this->filters);
    }

}