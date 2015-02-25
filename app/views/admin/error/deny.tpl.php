<html>
    <head>
      <!--Import materialize.css-->
      {{ view:'admin/inc/assets' }}
      <title>Denied Request | {{ $settings->app_name }}</title>
    </head>

    <body class="grey lighten-3">
    {% if(isset($disabled)) %}

        {% if($disabled == true) %}
    
            {{ view:'admin/inc/login_menu' }}

        {% endif %}

    {% else %}

        {{ view:'admin/inc/menu' }}

    {% endif %}

    <div class="header">
        <h1 class="light teal-text center">
            ERROR
        </h1>
        <h4 class="light grey-text center">
            401 Unauthorized
        </h4>
    </div>
    <br>
            <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content center">
                    <h4 class="light flow-text"><br>
                        <i class="large mdi-action-highlight-remove"></i>
                        <p>Unauthorized request was detected<br>
                        Noxen denied the request to avoid problems, please try again</p>
                    </h4>
                    <br>
                    <a class="btn waves-effect waves-light" href="{{ $url = $urlBuilder->to('/admin') }}"><i class="mdi-action-home left"></i> Home</a>
                </div>
            </div>
        </div>
    </div>
      <!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>