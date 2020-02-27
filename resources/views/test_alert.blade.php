@extends('layouts.app')

@section('content')
<div class="container">
    <test-alert :persons="{{$persons}}"></test-alert>
</div>
@endsection