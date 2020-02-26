@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <add-person :roles="{{$roles}}" :event-types="{{$event_types}}"></add-person>
</div>
@endsection