<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title><?php $content = 'Title'; $noxen->content($content, $page_id, $connection) ?> - {{ $settings->app_name }}</title>

  {{ view:'website/inc/header' }}
</head>
<body>
    {{ view: 'website/inc/menu' }}

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center teal-text text-lighten-2">
            <?php $content = 'Title'; $noxen->content($content, $page_id, $connection) ?>
        </h1>
        <div class="row center">
          <h5 class="header col s12 light">
              <?php $content = 'Subtitle'; $noxen->content($content, $page_id, $connection) ?>
            </h5>
        </div>
        <div class="row center">
          <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>
        </div>
        <br><br>

      </div>
    </div>
    <div class="parallax"><img src="{{ $urlBuilder->to('/assets/img/background1.jpg') }}" alt="Unsplashed background img 2"></div>
  </div>


  <div class="container">
    <div class="section">

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


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light"><?php $content = 'Image1_text'; $noxen->content($content, $page_id, $connection) ?></h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="{{ $urlBuilder->to('/assets/img/background3.jpg') }}" alt="Unsplashed background img 2"></div>
  </div>

  <div class="container">
    <div class="section">

      <div class="row">
        <div class="col s12 center">
          <h3><i class="mdi-content-send brown-text"></i></h3>
          <h4><?php $content = 'ContactUs_title'; $noxen->content($content, $page_id, $connection) ?></h4>
          <p class="left-align light"><?php $content = 'ContactUs_content'; $noxen->content($content, $page_id, $connection) ?></p>
        </div>
      </div>

    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light"><?php $content = 'Image2_text'; $noxen->content($content, $page_id, $connection) ?></h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="{{ $urlBuilder->to('/assets/img/background2.jpg') }}" alt="Unsplashed background img 3"></div>
  </div>

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
