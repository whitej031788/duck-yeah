@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <home-component :persons="{{$persons}}"></home-component>
</div>
@endsection