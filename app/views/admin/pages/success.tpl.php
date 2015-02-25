<html>
    <head>
        <!--Import materialize.css-->
        {{ view:'admin/inc/assets' }}
        <title>Success Request | {{ $settings->app_name }}</title>
    </head>

    <body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text center">
            SUCCESS
        </h1>
        <h4 class="light grey-text center">
            Action Done
        </h4>
    </div>
    <br>
            <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card-panel white main-content center">
                    <h4 class="light flow-text"><br>
                        <i class="large mdi-action-done green-text"></i>
                        <p>{{ $msg }}</p>
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