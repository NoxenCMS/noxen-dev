<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Logged In... - {{ $settings->app_name }}</title>
    <meta http-equiv="refresh" content="2; url={{ $url }}" />
  {{ view:'website/inc/header' }}
</head>
<body class="grey lighten-3">
    {{ view: 'website/inc/menu' }}



  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row" style="margin-top: 50px;">
        <div class="col s12 m8 offset-m2">
          <div class="row card-panel white center">
              <h1 class="light">{{ $msg }}</h1>
              <h4 class="light">Please Wait...</h4>
          </div>
        </div>
      </div>

    </div>
  </div>


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
