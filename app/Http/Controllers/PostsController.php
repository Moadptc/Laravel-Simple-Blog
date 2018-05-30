<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');

        //only
        //$this->middleware('auth' , ['only'=>'show']);

        //except
        $this->middleware('auth' , ['except'=>['index' , 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all();

        //$posts = Post::orderBy('created_at','DESC')->get();

        $posts = Post::orderBy('created_at','DESC')->paginate(3);
        $tags = Tag::all();
        return view('posts.index' , compact('posts','tags'));

        //return $posts;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('posts.create',compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$postTitle = $request->input('title');
        //return $postTitle;

        //simple validation
        $request->validate([
            'title'=>'bail|required|min:3',
            'body'=>'required',
            'photo'=>'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $post = new Post();

        $user = Auth::user();
        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        $now = date('YmdHis');
        $post->slug = str_replace(' ' , '-' , strtolower($post->title))
            .'-'.$now;
        $post->user_id = $user->id;

        // upload featured image if any
        if($request->hasFile('photo'))
        {
            $photo    = $request->photo;
            $filename = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('img/posts/' . $filename);
            //$photo->move($location); // if not used Image Intervention library

            Image::make($photo)->resize(800 , 400)
                ->insert( public_path('img/watermark.png') , 'bottom-right')
                ->save($location);

            $post->photo = $filename;

        }


        $post->save();

        // for record all values of tags or id(s) for tags
        $post->tags()->sync($request->tags);

        return redirect('/posts')->with('success', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug',$slug)->first();
        //$post = Post::find($id);

        return view('posts.show' , compact('post'));

        //return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        /*-----------  user update his post just ---------*/
        $userId = Auth::id();
        if($post->user_id !== $userId)
        {
            return redirect('/posts')->with('error','this is not ur post');
        }
        /*-----------  user update his post just ---------*/

        $tags = Tag::all();

        return view('posts.edit' , compact('post' , 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'bail|required|min:3',
            'body'=>'required'
        ]);

        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        $post->slug = str_replace(' ' , '-' , strtolower($post->title));

        /*-----------  user update his post just ---------*/
        $userId = Auth::id();
        if($post->user_id !== $userId)
        {
            return redirect('/posts')->with('error','this is not ur post');
        }
        /*-----------  user update his post just ---------*/

        /*--------- update photo --------*/

        if($request->hasFile('photo'))
        {
            $photo    = $request->photo;
            $filename = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('img/posts/' . $filename);
            //$photo->move($location); // if not used Image Intervention library

            Image::make($photo)->resize(800 , 400)
                ->insert( public_path('img/watermark.png') , 'bottom-right')
                ->save($location);

            $post->photo = $filename;

        }

        /*--------- update photo --------*/

        $post->save();

        $post->tags()->sync($request->tags);

        return redirect('/posts/'.$post->slug)->with('success', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        /*-----------  user update his post just ---------*/
        $userId = Auth::id();
        if($post->user_id !== $userId)
        {
            return redirect('/posts')->with('error','this is not ur post');
        }
        /*-----------  user update his post just ---------*/


        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted Successfully');


    }
}
