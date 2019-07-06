<?php
/**
 * Created by PhpStorm.
 * User: shisiying
 * Date: 2019-07-06
 * Time: 17:40
 */

namespace App\Filters;


use Illuminate\Http\Request;
use App\User;

class ThreadsFilters extends Filters
{

    protected $filters = ['by'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    protected function by($username)
    {
        $user = User::where('name',$username)->firstOrFail();

        return $this->builder->where('user_id',$user->id);
    }

}