<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <a href="{{ route('boilerplate.user.profile') }}">
                    <img src="{{ Auth::user()->avatar_url }}" class="img-circle avatar" alt="{{ Auth::user()->name }}"/>
                </a>
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="{{ route('boilerplate.logout') }}" class="logout">
                    <i class="fa fa-circle text-success"></i> {{ __('boilerplate::layout.online') }}
                </a>
            </div>
        </div>
        {!! $menu !!}
    </section>
</aside>
