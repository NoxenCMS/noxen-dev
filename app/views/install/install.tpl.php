<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Install Noxen {{ $noxen_version }}</title>

  {{ view:'website/inc/header' }}
</head>
<body class="grey lighten-3">
    <nav class="white" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" href="#" class="brand-logo">Noxen - {{ $noxen_version }}</a>
      </div>
    </div>
  </nav>

<form method="POST">
<div class="container">
    <div class="section card-panel" style="margin-top: 50px;">
        <div class="row">
            <div class="col s12 ">
                <h1 class="light center">Install Preferences</h1><br>
                    <div class="row">
                        <div class="col s12 m12">
                            <h4 class="light">Step 1 - Set up database</h4>
                            <center>
                                <p class="center">File: app/config/database.php</p>
                                <p class="center">Replace: DATABASE_NAME, DATABASE_HOST, USERNAME, PASSWORD with your database information</p>
                                <img class="responsive-img" src="<?php echo $urlBuilder->to('/assets/img/install_database.png') ?>">
                                <p class="center red-text">Please save the file before going to the next step...</p>
                            </center>
                            <h4 class="light">Step 2 - Default Information</h4>
                            <div class="row">
                              <div class="input-field col s6">
                                <input id="name" name="name" type="text" class="validate">
                                <label for="name">Website Name</label>
                              </div>
                              <div class="input-field col s6">
                                <input id="owner" name="owner" type="text" class="validate">
                                <label for="owner">Website Owner</label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="input-field col s6">
                                  <input style="display:none">
					               <input type="password" style="display:none">
                                <input id="username" name="username" type="text" class="validate">
                                <label for="username">Administrator Username</label>
                              </div>
                              <div class="input-field col s6">
                                <input id="email" name="email" type="email" class="validate">
                                <label for="email">Administrator Email</label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="input-field col s6">
                                  <input style="display:none">
					               <input type="password" style="display:none">
                                <input id="password" name="password" type="password" class="validate">
                                <label for="password">Administrator Password</label>
                              </div>
                              <div class="input-field col s6">
                                <input id="repeat_password" name="repeat_password" type="password" class="validate">
                                <label for="repeat_password">Repeat Password</label>
                              </div>
                            </div>
                            <div class="center">
                                <button class="btn waves-effect waves-light" type="submit" name="action">Install Noxen {{ $noxen_version }}
                                    <i class="mdi-content-send right"></i>
                                </button>
                                <p class="center red-text">Make sure your database information is correct, and make sure the file is saved</p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</form>
<br><br><br>
  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Noxen {{ $noxen_version }}</h5>
          <p class="grey-text text-lighten-4">Noxen by Erik Campobadal is licensed under a Creative Commons Attribution 4.0 International License. To view a copy of this license, visit http://creativecommons.org/licenses/by/4.0/.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="{{ $noxen_website }}">Noxen Website</a></li>
            <li><a class="white-text" href="{{ $mako_website }}">Mako Framework</a></li>
            <li><a class="white-text" href="{{ $materialize_website }}">Materialize</a></li>
            <li><a class="white-text" href="{{ $author_website }}">Author Website</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        
          <div class="left">
            Copyright &copy; {{ date("Y") }} Noxen {{ $noxen_version }}
          </div>
          
          <div class="right">
            Made by {{ $noxen_author }}
          </div>
      
        </div>
    </div>
  </footer>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="{{ $urlBuilder->to('/assets/js/materialize.js') }}"></script>
    <script src="{{ $urlBuilder->to('/assets/js/init.js') }}"></script>



  </body>
</html>
