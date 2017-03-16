@extends(Config::get('liddleforum.blade.layout'))

@push(Config::get('liddleforum.stacks.head'))
<link href="//vendor/liddledev/liddleforum/assets/css/liddleforum.css" rel="stylesheet">
@endpush

@section('content')

    <div class="liddleforum-container">

        <h1>Liddle Forum</h1>
        <h2>A simple forum for your Laravel application</h2>

        <hr>

        @yield('liddleforum_content_inner')
    </div>

@endsection

@push(Config::get('liddleforum.blade.stacks.footer'))
<script src="//vendor/liddledev/liddleforum/assets/js/liddleforum.js"></script>
@endpush
