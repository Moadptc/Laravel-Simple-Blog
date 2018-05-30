@extends('layouts.default')

@section('content')

    <h2 class="display-5">Edit {{ $post->title }}</h2>
    <hr>

    {!! Form::open(['action'=>['PostsController@update' , $post->id] , 'method'=>'POST','files'=>true]) !!}

        {{ Form::hidden('_method' , 'PUT') }}

        <div class="form-group">
            {{ Form::label('title') }}
            {{ Form::text('title' , $post->title ,
             ['placeholder'=>'Enter Post Title' , 'class'=>'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('body') }}
            {{ Form::textarea('body' , $post->body ,
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
            {{ Form::submit('Update' , [ 'class'=>'btn btn-primary']) }}
        </div>

    {!! Form::close() !!}

@endsection


@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.tags').select2().val({!! json_encode($post->tags()->pluck('id')) !!}).trigger('change');
        });
    </script>
@endsection

