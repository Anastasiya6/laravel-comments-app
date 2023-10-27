@extends('layouts.app')

@section('content')
    <div id="app">
        <comments></comments>
    </div>

    <script type="module" src="{{ asset('dist/js/app.js') }}"></script>
@endsection
