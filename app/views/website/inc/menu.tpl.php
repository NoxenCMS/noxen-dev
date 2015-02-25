<nav class="white" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" href="{{ $urlBuilder->to('/demo') }}" class="brand-logo">{{ $settings->app_name }}</a>
        <ul id="nav-mobile" class="right side-nav">
            {% if(isset($disabled)) %}
            
            {% else %}
            
            {% if($isLoggedIn == 1) %}
            {% if($moderator == 1) %}<li><a href="{{ $urlBuilder->to('/admin') }}">Admin Panel</a></li>{% endif %}
                <li><a href="{{ $urlBuilder->to('/demo/account') }}">My Account</a></li>
                <li><a href="{{ $urlBuilder->to('/demo/news') }}">News</a></li>
                <li><a href="{{ $urlBuilder->to('/demo/logout') }}">Logout</a></li>
            {% else %}
                <li><a href="{{ $urlBuilder->to('/demo/register') }}">Register</a></li>
                <li><a href="{{ $urlBuilder->to('/demo/login') }}">Login</a></li>
            {% endif %}
            
            {% endif %}
            
        </ul><a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </div>
  </nav>