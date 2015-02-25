<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Edit Website Footer | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            Edit Website Footer
        </h1>
        <h4 class="light grey-text center">
            Edt the current website footer
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/website/footer") }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                    <br>
                    <div class="row">
                        <div class="col s12 m12">
                            <form method="POST">
                                <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
                            <div class="row">
                                <div class="col s4 m3 l2 center">
                                    <i class="medium mdi-action-label"></i>
                                </div>
                                <div class="col s8 m9 l10">
                                    <div class="input-field col s12">
                                        <input id="title" name="title" type="text" value="{{ $footer->title }}" class="validate">
                                        <label for="title">Footer Title</label>
                                    </div>
                                </div>
                            </div>   
                            
                            <div class="row">
                                <div class="col s4 m3 l2 center">
                                    <i class="medium mdi-notification-sms"></i>
                                </div>
                                <div class="col s8 m9 l10">
                                    <div class="input-field col s12">
                                        <textarea id="bio" name="bio" class="materialize-textarea">{{ $footer->bio }}</textarea>

                                        <label for="bio">Footer Description</label>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                            <div class="col s12 center">
                                  <button class="btn waves-effect waves-light" type="submit" name="action">Update Settings
                                    <i class="mdi-content-send right"></i>
                                  </button>
                            </div>
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