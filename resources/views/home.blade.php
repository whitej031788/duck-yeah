@extends('layouts.app')

@section('content')
<div class="container">
    <home-component :persons="{{$persons}}"></home-component>
</div>
@endsection