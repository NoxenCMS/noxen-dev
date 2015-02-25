<html>
    <head>
      <!--Import materialize.css-->
      {{ view:'admin/inc/assets' }}
      <title>Security Check | {{ $settings->app_name }}</title>
    </head>

    <body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text center">
            Confirmation Page
        </h1>
        <h4 class="light grey-text center">
            Please review the information before continue
        </h4>
    </div>
    <br>
            <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card-panel white main-content center">
                    <h4 class="light flow-text"><br>
                        <i class="large mdi-action-info-outline"></i>
                        
                            <p>
                                Are you sure you want to continue?
                            </p>
                        </h4>
                        <form method="POST">
                            <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
                            <div class="row">
                                <div class="col s6">
                                    <a href="{{ $urlBuilder->base() }}" class="waves-effect waves-light red btn"><i class="mdi-navigation-close right"></i>No</a>
                                </div>
                                <div class="col s6">
                                    <button class="btn waves-effect waves-light green" type="submit" name="action">Yes
                                        <i class="mdi-action-done left"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    
                    <br>
                </div>
            </div>
        </div>
    </div>
      <!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>