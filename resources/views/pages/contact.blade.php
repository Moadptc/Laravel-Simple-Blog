@extends('layouts.default')

@section('content')

    {!! Form::open(['action'=>'PagesController@dosend' , 'method'=>'POST']) !!}

    <div class="form-group">
        {{ Form::label('name') }}
        {{ Form::text('name' , old('name') ,
         ['placeholder'=>'Enter Your Name' , 'class'=>'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('email') }}
        {{ Form::text('email' , old('email') ,
         ['placeholder'=>'Enter Your Email' , 'class'=>'form-control' , 'rows'=>'6']) }}
    </div>

    <div class="form-group">
        {{ Form::label('subject') }}
        {{ Form::text('subject' , old('subject') ,
         ['placeholder'=>'Enter Your Subject' , 'class'=>'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('body') }}
        {{ Form::textarea('body' , old('body') ,
         ['placeholder'=>'Enter Body Message' , 'class'=>'form-control']) }}
    </div>


    <div class="form-group float-right">
        {{ Form::submit('Save' , [ 'class'=>'btn btn-primary']) }}
    </div>

    {!! Form::close() !!}

@endsection
