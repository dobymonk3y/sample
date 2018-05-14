@extends('layouts.default')
@section('title','Sample - HomePage')
@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">
            You are reading <a href="{{ route('home') }}">Frankie's laravel demo</a>
        </p>
        <p>
            Nothing is impossible !
        </p>
        <p>
            <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">Sign Up Now</a>
        </p>
    </div>
@stop