@extends('layouts.app')
@section('content')

    test-view
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">deconnection</button>
    </form>

@endsection


