@extends('layouts.cms.header')
@section('content')
    <main class="main">
        <div id="app">
            <list_genre></list_genre>

        </div>

    </main>
@endsection
@push('scripts')
<script src="/js/app.js" ></script>
@endpush