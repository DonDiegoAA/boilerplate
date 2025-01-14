<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('/boilerplate.min.css', '/assets/vendor/boilerplate') }}">
    @stack('css')
</head>
<body class="sidebar-mini fixed skin-{{ config('boilerplate.app.skin', 'blue') }}">
    <div class="wrapper">
        @include('boilerplate::layout.header')
        @include('boilerplate::layout.mainsidebar')
        <div class="content-wrapper">
            <section class="content-header">
                @include('boilerplate::layout.contentheader')
            </section>
            <section class="content">
                @yield('content')
            </section>
        </div>
        @include('boilerplate::layout.footer')
    </div>
    <script src="{{ mix('/boilerplate.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script>
        $(function() {
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
            bootbox.setLocale("{{ App::getLocale() }}");
            @if(Session::has('growl'))
                @if(is_array(Session::get('growl')))
                    growl("{!! Session::get('growl')[0] !!}", "{{ Session::get('growl')[1] }}");
                @else
                    growl("{{Session::get('growl')}}");
                @endif
            @endif
            $('.logout').click(function(e){
                e.preventDefault();
                if(bootbox.confirm("{{ __('boilerplate::layout.logoutconfirm') }}", function(e){
                    if(e === false) return;
                    $('#logout-form').submit();
                }));
            });
        });
    </script>
    @stack('js')
</body>
</html>
