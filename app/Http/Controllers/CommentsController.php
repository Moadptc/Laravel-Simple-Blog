<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request , $slug)
    {

        $request->validate([
            'body'=>'required|min:3|max:500'
        ]);

        //Post
        $post = Post::where('slug',$slug)->firstOrFail();

        //Current_user
        $userId = Auth::id();

        $comment = new Comment();
        $comment->body = $request->body;

        // method 1
        $comment->post()->associate($post);

        //method 2
        $comment->user_id = $userId;

        $comment->save();
        return redirect()->route('posts.show' , $slug)
            ->with('success' , 'Comment Added Successfully');

    }
}
