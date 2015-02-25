<html>
<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Create Content | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text center">
            Create Content
        </h1>
        <h4 class="light grey-text center">
            Create content for page {{ $page->name }}
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">



                <div class="card-panel white main-content center">
                    <br>
                    <div class="row">
                        <div class="col s12 m6" >
                            <form method="POST">
                                <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="mdi-action-class prefix"></i>
                                        <input id="name" name="name" type="text">
                                        <label for="name">Content Name</label>
                                    </div>
                                    <div class="input-field col s12">
                                    <i class="mdi-editor-mode-edit prefix"></i>
                                    <textarea id="content" name="content" class="materialize-textarea"></textarea>

                                    <label for="content">Content</label>
                                  </div>
                                </div>
                        </div>
                            
                        <div class="col s12 m6 center">
                            <i class="medium mdi-action-note-add"></i>
                            <h3>New Content</h3>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col s6">
                            <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/pages') }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                        </div>
                        <div class="col s6">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Create Content
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
    </div>

    <!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
</body>

</html>