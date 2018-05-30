@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                    <div class="float-right">
                        <a href="/posts/create" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i>  Add Post
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Your Posts</h3>

                        <table class="table table-striped table-responsive-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Created</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($posts as $post)
                            <tr>
                                <th scope="row">{{ $k++ }}</th>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td>
                                    <a href="/posts/{{ $post->id }}/edit" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i> Edit Post
                                    </a>
                                </td>
                                <td>
                                    {!! Form::open(['action'=>['PostsController@destroy' , $post->id] , 'method'=>'POST']) !!}
                                    {{ Form::hidden('_method' , 'DELETE') }}

                                    <button class="btn btn-danger btn-sm" type="submit">
                                        <i class="fas fa-trash"></i> Delete Post
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="5">
                                    {{ $posts->links() }}
                                </td>
                            </tr>

                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
