<main class="main">

    @include('layouts/partials/_leftsidebar')

    <section class="content">
        @if(isset($warnings) && $warnings->count()>0)
            <div class="warning-carousel warning">
                @foreach($warnings as $warning)
                    <span>{{ strip_tags($warning->body) }}</span>
                @endforeach
            </div>
            <div class="main-section warning-height-change">
        @else
            <div class="main-section padding-top-15">
        @endif

        @yield('content')
        </div>
    </section>

    @include('layouts/partials/_rightsidebar')

</main>