<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // current user_id
        $userId = Auth::id();

        // find all posts by user_id
        // $post = Post::where('user_id',$userId);

        $user = User::find($userId);
        $posts = $user->posts()->paginate(5);


        $k = 1;

        return view('home' , compact(['posts','k']));
    }
}
