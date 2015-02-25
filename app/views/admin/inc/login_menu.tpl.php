    <nav>
        <div class="nav-wrapper teal">

            <div class="container">
                <a href="{{ $urlBuilder->to('/admin') }}" class="brand-logo">{{ $settings->app_name }}</a>
                <ul id="nav-mobile" class="right side-nav">
                    <li><a href="{{ $urlBuilder->to('/') }}">Back to site</a>
                    </li>
                </ul>

                <!-- Include this line below -->
                <a class="button-collapse" href="#" data-activates="nav-mobile"><i class="mdi-navigation-menu"></i></a>
                <!-- End -->
            </div>
        </div>
    </nav>