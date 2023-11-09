@extends('layouts.main')
@section('content')
    <div id="app">
        <index-component></index-component>
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
@endsection
