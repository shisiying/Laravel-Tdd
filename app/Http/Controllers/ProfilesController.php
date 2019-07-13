<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use App\User;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show',[
            'profileUser'=>$user,
            'threads' => $user->threads()->paginate(10),
            'activities' => Activity::feed($user)
        ]);
    }
}
