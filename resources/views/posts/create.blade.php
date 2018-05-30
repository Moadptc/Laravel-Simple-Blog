@extends('layouts.default')

@section('content')

    <h2 class="display-5">Add New Post</h2>
    <hr>

    {!! Form::open(['action'=>'PostsController@store','method'=>'POST','files'=>true]) !!}

        <div class="form-group">
            {{ Form::label('title') }}
            {{ Form::text('title' , old('title') ,
             ['placeholder'=>'Enter Post Title' , 'class'=>'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('body') }}
            {{ Form::textarea('body' , old('body') ,
             ['placeholder'=>'Enter Post Body' , 'class'=>'form-control ckeditor' , 'rows'=>'6']) }}
        </div>

        <div class="form-group">
            {{ Form::label('Tags') }}
            <select name="tags[]" class="form-control tags" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            {{ Form::label('Featured Image') }}
            {{ Form::file('photo', [ 'class'=>'form-control']) }}
        </div>

        <div class="form-group float-right">
            {{ Form::submit('Save' , [ 'class'=>'btn btn-primary']) }}
        </div>

    {!! Form::close() !!}

@endsection


@section('javascript')
    <script>
        $(document).ready(function() {
            $('.tags').select2();
        });
    </script>
@endsection
