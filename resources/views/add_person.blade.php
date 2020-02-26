@extends('layouts.app')

@section('content')
<div class="container">
    @if(isset($person))
        <add-edit-person :person="{{$person}}" :roles="{{$roles}}" :event-types="{{$event_types}}"></add-edit-person>
    @else
        <add-edit-person :roles="{{$roles}}" :event-types="{{$event_types}}"></add-edit-person>
    @endif

</div>
@endsection