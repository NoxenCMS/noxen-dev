<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>{{ $loggedUser->username }} - {{ $settings->app_name }}</title>

  {{ view:'website/inc/header' }}
</head>
<body class="grey lighten-3">
    {{ view: 'website/inc/menu' }}


<div class="container">
    <div class="section card-panel" style="margin-top: 50px;">
        <div class="row">
            <div class="col s12 ">
                <h1 class="light center">Account Information</h1><br>
                    <div class="row">
                        <div class="col s12 m6">
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-social-person"></i>
                                </div>
                                <div class="col s8 m9 center">
                                    <p class="flow-text">{{ $loggedUser->username }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-communication-email"></i>
                                </div>
                                <div class="col s8 m9 center">
                                    <p class="flow-text">{{ $loggedUser->email }}</p>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="col s12 m6">

                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    {% if($loggedUser->banned == 0) %}
                                            <i class="medium mdi-action-lock-open "></i>
                                        {% else %}
                                            <i class="medium mdi-action-lock-outline"></i>
                                        {% endif %}
                                </div>
                                <div class="col s8 m9 center">
                                    <p class="flow-text">
                                        {% if($loggedUser->banned == 0) %}
                                            <span class="green-text">Not Banned</span>
                                        {% else %}
                                            <span class="red-text">Banned</span>
                                        {% endif %}
                                    </p>
                                </div>
                            </div>

                                                        <div class="row">
                                <div class="col s4 m3 center">
                                    {% if($loggedUser->activated == 0) %}
                                            <i class="medium mdi-action-done"></i>
                                        {% else %}
                                            <i class="medium mdi-action-done-all"></i>
                                        {% endif %}
                                </div>
                                <div class="col s8 m9 center">
                                    <p class="flow-text">
                                        {% if($loggedUser->activated == 0) %}
                                            <span class="orange-text">Not Activated</span>
                                        {% else %}
                                            <span class="green-text">Activated</span>
                                        {% endif %}
                                    </p>
                                </div>
                            </div>
                            
                        </div>
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
