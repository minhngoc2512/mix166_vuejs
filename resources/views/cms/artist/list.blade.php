@extends('layouts.cms.header')
@section('content')
    <main class="main">
        <div id="app">
            <list_artist></list_artist>

        </div>

    </main>
@endsection
@push('scripts')
<script src="/js/app.js" ></script>
@endpush