<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Login - {{ $settings->app_name }}</title>

  {{ view:'website/inc/header' }}
</head>
<body class="grey lighten-3">
    {{ view: 'website/inc/menu' }}



<form method="POST">
<input name="token" style="display:none" readonly type="text" value="{{ $token }}">
<input style="display:none">
<input type="password" style="display:none">
  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m6 offset-m3">
        <div class="center">
          <h1 class="light">Login</h1>
          <h4 class="light">Please login to {{ $settings->app_name }}</h4><br>
        </div>
          <div class="row card-panel white">
            <div class="input-field col s12 m6">
              <input id="email" name="email" type="email" class="validate">
              <label for="email">Email</label>
            </div>
            <div class="input-field col s12 m6">
              <input id="password" name="password" type="password" class="validate">
              <label for="password">Password</label>
            </div><br><br><br><br>
            <div  class="center">
              <button class="btn waves-effect waves-light" type="submit" name="action">Login
                <i class="mdi-content-send right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</form>

  <div class="container">
    <div class="section card-panel">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="mdi-image-flash-on"></i></h2>
            <h5 class="center"><?php $content = 'Features1_title'; $noxen->content($content, $page_id, $connection) ?></h5>

            <p class="light"><?php $content = 'Features1_content'; $noxen->content($content, $page_id, $connection) ?></p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="mdi-social-group"></i></h2>
            <h5 class="center"><?php $content = 'Features2_title'; $noxen->content($content, $page_id, $connection) ?></h5>

            <p class="light"><?php $content = 'Features2_content'; $noxen->content($content, $page_id, $connection) ?></p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="mdi-action-settings"></i></h2>
            <h5 class="center"><?php $content = 'Features3_title'; $noxen->content($content, $page_id, $connection) ?></h5>

            <p class="light"><?php $content = 'Features3_content'; $noxen->content($content, $page_id, $connection) ?></p>
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
