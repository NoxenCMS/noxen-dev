<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Create User | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text center">
            Create User
        </h1>
        <h4 class="light grey-text center">
            Create an account for the site
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">


                

                <div class="card-panel white main-content center">
                    <br>
                    <div class="row">
                        <div class="col s12 m6">
                            <form method="POST">
                                <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="mdi-action-account-circle prefix"></i>
                                        <input style="display:none" type="text" name="fakeusernameremembered" />
                                        <input id="username" name="username" type="text">
                                        <label for="username">Username</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="mdi-action-lock prefix"></i>
                                        <input style="display:none" type="password" name="fakepasswordremembered" />
                                        <input id="password" name="password" type="password">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="mdi-action-lock prefix"></i>
                                        <input id="repeat_password" name="repeat_password" type="password">
                                        <label for="repeat_password">Repeat Password</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="mdi-communication-email prefix"></i>
                                        <input id="email" name="email" type="text">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                        </div>
                        <div class="col s12 m6 center"><br>
                            <i class="medium mdi-action-account-circle"></i>
                            <h3>User Account</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/users') }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                        </div>
                        <div class="col s6">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Create Account
                                <i class="mdi-content-send right"></i>
                            </button>
                        </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
</body>

</html>