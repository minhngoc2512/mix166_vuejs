@extends('layouts.cms.header') @section('content')
    <main class="main">
        <div id="app">
            <edit_file :id="{{$id}}"></edit_file>
        </div>
    </main>
@endsection @push('scripts')
    <script src="/js/app.js"></script>
@endpush