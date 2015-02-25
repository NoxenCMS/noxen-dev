<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>News - {{ $settings->app_name }}</title>

  {{ view:'website/inc/header' }}
</head>
<body class="grey lighten-3">
    {{ view: 'website/inc/menu' }}

    {% foreach($posts as $post) %}
        <div class="container">
            <div class="section card-panel" style="margin-top: 50px;">
                <div class="row">
                    <div class="col s12 ">
                        <h4 class="light">{{ $post->title }}</h4>
                        <p>{{ $post->full_text }}</p>
                    </div>
                </div>
            </div>
        </div>
    {% endforeach %}
<br><br><br>
  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">{{ $footer->title }}</h5>
          <p class="grey-text text-lighten-4">{{ $footer->bio }}</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        
          <div class="left">
            Copyright &copy; {{ date("Y") }} {{ $settings->app_name }} {{ $settings->app_version }}
          </div>
          
          <div class="right">
            Made by {{ $settings->app_author }}
          </div>
      
        </div>
    </div>
  </footer>


    {{ view:'website/inc/footer' }}


  </body>
</html>
