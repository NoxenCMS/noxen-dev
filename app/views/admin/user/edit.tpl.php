<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Edit {{ $user->username }} | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            Edit {{ $user->username }}
        </h1>
        <h4 class="light grey-text center">
            Edit user information
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <div class="row">
                        <br><br>
                        <div class="col s12 m6">
                            <div class="row">
                                <div class="col s3 center">
                                    <i class="medium mdi-social-person"></i>
                                </div>
                                <div class="col s9">
                                    <div class="hide-on-med-and-up" style="min-height: 10px;"></div>
                                    <p class="flow-text">{{ $user->username }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6">

                            <div class="row">
                                <div class="col s11">
                                    <form method="POST">
                                        
                                        <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
                                        
                                        <div class="input-field col s12">
                                            <i class="mdi-communication-email prefix"></i>
                                            <input id="email" type="email" name="email" value="{{ $user->email }}" class="validate">
                                            <label for="email">User Email</label>
                                        </div>
                                        
                                        <br>
                                    
                                </div>
                                <div class="col s1">
                                    &nbsp;
                                </div>
                        </div>
                            
                    </div>
                </div>
                        <div class="row">
                            <div class="col s12 center">
                                <button class="btn waves-effect waves-light center" type="submit" name="action">Update User
                                        <i class="mdi-content-send right"></i>
                                    </button>
                                    </form>
                            </div>
                        </div>
            </div>
        </div>
    </div>

<!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>