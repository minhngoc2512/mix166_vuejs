@extends('layouts.cms.header')
@section('content')
    <main class="main">
        <div id="app">
            <list_user></list_user>

        </div>

    </main>
@endsection
@push('scripts')
<script src="/js/app.js" ></script>
@endpush