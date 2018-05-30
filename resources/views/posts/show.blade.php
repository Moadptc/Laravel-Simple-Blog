@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h2>{{ $post->title }}</h2>

            @if( !Auth::guest() && (Auth::user()->id == $post->user_id) )
                <div class="row">
                    <div class="col-md-6">
                        <a href="/posts/{{ $post->id }}/edit" class="btn btn-secondary">
                            <i class="fas fa-edit"></i> Edit Post
                        </a>
                    </div>
                    <div class="col-md-6">
                        {!! Form::open(['action'=>['PostsController@destroy' , $post->id] , 'method'=>'POST']) !!}
                        {{ Form::hidden('_method' , 'DELETE') }}

                        <button class="btn btn-danger float-right" type="submit">
                            <i class="fas fa-trash"></i> Delete Post
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endif

            <hr>
            <div>
                <img src="{{ asset('img/posts/' . $post->photo) }}" class="img-fluid" alt="Responsive image">
                <p class="lead">
                    {!! $post->body !!}
                </p>
            </div>

            @foreach($post->tags as $tag)
                <a href="{{ route('tags.show' , $tag->id) }}">
            <span class="badge badge-primary p-2 mr-1">
                <i class="fas fa-tag"></i> {{ $tag->tag }}
            </span>
                </a>
            @endforeach

            <hr>

            <h4>Comments {{ $post->comments->count() }}</h4>


            <div class="container">

                @foreach($post->comments as $comment)
                    <div class="row mt-1">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="{{ asset('img/user.png') }}" class="img img-rounded img-fluid"/>
                                            <p class="text-secondary text-center">{{ $comment->user->name }}</p>
                                            {{--<p class="text-secondary text-center">{{ $comment->craeted_at->format('d M y') }}</p>--}}
                                            <p class="text-secondary text-center">{{ \Carbon\Carbon::parse($comment->craeted_at)->format('d M Y')}}</p>
                                        </div>
                                        <div class="col-md-10">

                                            <div class="clearfix"></div>
                                            <p> {{ $comment->body }} </p>
                                            <p>
                                                <a class="float-right btn btn-outline-primary ml-2"> <i class="fa fa-reply"></i> Reply</a>
                                                <a class="float-right btn text-white btn-danger"> <i class="fa fa-heart"></i> Like</a>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>





            <div class="card mt-3">
                <h5 class="card-header">Add Your Comment</h5>
                <div class="card-body">

                    @guest
                    <div class="alert alert-info">Please Login To Comment</div>
                    @else

                        <form action="{{ route('comments.store' , $post->slug) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="comment"></label>
                                <textarea name="body" id="comment" cols="30" placeholder="Enter Your Comment ...."
                                          rows="6" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary float-right">
                                    Add Comment
                                </button>
                            </div>
                        </form>

                        @endguest



                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white">Post Tags</div>
                <div class="card-body text-primary">
                    <p class="card-text">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('tags.show' , $tag->id) }}">
                                <span class="badge badge-primary p-2 mb-2 mr-1">
                                    <i class="fas fa-tag"></i> {{ $tag->tag }}
                                </span>
                            </a>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>


@endsection

