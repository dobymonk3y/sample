@extends('layouts.default')
@section('title','Sample - Oops')
@section('content')
    try {
    $this->authorize ('update', $user);
    return view ('users.edit', compact ('user'));
    } catch (\Exception $e) {
    abort(500, $e->getMessage());
    }
@stop