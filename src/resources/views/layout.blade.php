@extends(Config::get('liddleforum.blade.layout'))

@push(Config::get('liddleforum.blade.stacks.head'))
<link href="/vendor/liddledev/liddleforum/assets/css/liddleforum.css" rel="stylesheet">
<link href="/vendor/liddledev/liddleforum/assets/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endpush

@section('content')

    <div class="liddleforum-container">

        @if(\LiddleDev\LiddleForum\Helpers\UserHelper::isAdmin(\Auth::user()))
            <a href="{{ route('liddleforum.admin.index') }}" class="btn btn-danger pull-right">
                <i class="fa fa-fw fa-cog"></i> Admin Panel
            </a>
        @endif

        <h1>{{ config('liddleforum.text.heading') }}</h1>
        <h2>{{ config('liddleforum.text.subheading') }}</h2>

        <hr>

        @include('liddleforum::flashed.flashed')

        @yield('liddleforum_content_inner')
    </div>

@endsection

@push(Config::get('liddleforum.blade.stacks.footer'))
<script src="/vendor/liddledev/liddleforum/assets/js/liddleforum.js"></script>
@endpush
