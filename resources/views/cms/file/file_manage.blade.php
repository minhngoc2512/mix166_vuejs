@extends('layouts.cms.header')
@section('content')
    <main class="main">
        <div id="app">
            <list_file></list_file>

        </div>

    </main>
@endsection
@push('scripts')
<script src="/js/app.js" ></script>
@endpush