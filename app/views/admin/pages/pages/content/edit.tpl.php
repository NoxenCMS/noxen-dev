<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Edit {{ $content->name }} | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            Edit {{ $content->name }} Content
        </h1>
        <h4 class="light grey-text center">
            Edit Content Information
        </h4>
    </div>
    <br>
    <div class="container">
        <form method="POST">
            <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
        <div class="row">
            <div class="col s12">

                <div class="card-panel white main-content">
                
                <div class="row">
                    <div class="col s12">
                <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to("/admin/pages/$page->id/$content->id") }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                    </div>
                </div>
                    <div class="row">
                        <div class="col s12 m6">
                    
                            <div class="row"><br>
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-communication-vpn-key"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">Content ID: #{{ $content->id }}</p>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col s12 m6">

                            <div class="row"><br>
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-action-label"></i>
                                </div>
                                <div class="col s8 m9">
                                    <div class="input-field col s12">
                                        <input id="name" name="name" type="text" value="{{ $content->name }}" class="validate">
                                        <label for="name">Content Name</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12 m12">
                            <div class="row"><br>
                                <div class="col s4 m2 center">
                                    <i class="medium mdi-notification-sms"></i>
                                </div>
                                <div class="col s8 m10">
                                    <div class="input-field col s12">
                                        <textarea name="content" class="materialize-textarea">{{ $content->content }}</textarea>
                                        <label>Content</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col s12 center">
                <button class="btn waves-effect waves-light" type="submit" name="action">Update Page
                                <i class="mdi-content-send right"></i>
                            </button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </form>
    </div>

<!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>