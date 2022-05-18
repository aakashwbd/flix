@extends('layouts.landing.index')
@section('content')
    <div class="container content-config">

        <div class="bg-primary py-3 px-2 text-center">
            <span class="text-white fw-bold">About Us</span>
        </div>
        <div class="bg-white p-2">
            <article id="aboutUs">Please create an about at admin panel to view in your site</article>

        </div>

    </div>

@endsection

@push('custom-js')
    <script>
        /**
         * Change the current page title
         * */
        let currentPath = window.location.pathname
        currentPath === '/about'? document.title = 'About' : ''

    </script>
@endpush

