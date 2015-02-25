<html>
<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Create Group | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text center">
            Create Group
        </h1>
        <h4 class="light grey-text center">
            Create a group
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
                                        <i class="mdi-social-group prefix"></i>
                                        <input id="name" name="name" type="text">
                                        <label for="name">Group Name</label>
                                    </div>
                                </div>
                                <span>
                                    <div class="row">
                                    <div class="col s12">
                                        
                                    <input type="checkbox" id="moderator" name="moderator" />
                                    <label for="moderator">Moderator Group</label>
                                
                                    </div>
                                </div>
                                    <b>*Moderator Group:</b> Can access admin panel
                                </span>
                        </div>
                            
                        <div class="col s12 m6 center">
                            <i class="medium mdi-social-group-add"></i>
                            <h3>New Group</h3>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col s6">
                            <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/groups') }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                        </div>
                        <div class="col s6">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Create Group
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