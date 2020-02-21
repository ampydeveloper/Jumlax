<!DOCTYPE html>
@langrtl
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    @else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        @endlangrtl
        <head>        
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>@yield('title', app_name())</title>
            <meta name="description" content="@yield('meta_description', 'Jumla')">
            <meta name="author" content="@yield('meta_author', 'League Of Clicks')">
            <link rel="shortcut icon" type="image/png" href="{{URL::asset('/favicon.png')}}"/>
            @yield('meta')

            @stack('before-styles')
            {{ style(mix('css/frontend.css')) }}
            <link href="{{asset('assets/css/intlTelInput.min.css')}}">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" integrity="sha256-bLNUHzSMEvxBhoysBE7EXYlIrmo7+n7F4oJra1IgOaM=" crossorigin="anonymous" />
            @stack('after-styles')
        </head>  
        <body>
            <div id="app">
                @yield('nav')
                @include('includes.partials.logged-in-as')

                @yield('content')
                @include('frontend.includes.footer')
            </div>

            <!-- Scripts -->
            @stack('before-scripts')
            {!! script(mix('js/manifest.js')) !!}
            {!! script(mix('js/vendor.js')) !!}
            {!! script(mix('js/frontend.js')) !!}
            @stack('after-scripts')
            <script type="text/javascript">
                var apiUrl = '{{url('')}}',
                        siyApp = {};
            </script>
            <script src="{{ asset('assets/js/core.min.js') }}"></script>
            <script src="{{ asset('assets/js/script.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
            @stack('scripts')
            @include('includes.partials.ga')
        </body>
    </html>