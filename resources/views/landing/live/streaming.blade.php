@extends('layouts.landing.index')
@section('content')


    <div style="margin-top: 100px">
        @if ($type === 'broadcaster')

            <broadcaster :auth_user_id="{{ $id }}" env="{{ env('APP_ENV') }}"
                         turn_url="{{ env('TURN_SERVER_URL') }}" turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                         turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}" />

        @else
            <viewer stream_id="{{ $streamId }}" :auth_user_id="{{ $id }}"
                    turn_url="{{ env('TURN_SERVER_URL') }}" turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                    turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}" />
        @endif
    </div>

{{--    {{ $id }}--}}
{{--    {{ $streamId }}--}}
@endsection
{{--@push('custom-js')--}}
{{--    <script>--}}
{{--        let user = JSON.parse( localStorage.getItem('user'))--}}

{{--        console.log(user)--}}
{{--    </script>--}}
{{--@endpush--}}
