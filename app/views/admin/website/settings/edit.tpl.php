<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Edit Website Settings | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            Edit Website Settings
        </h1>
        <h4 class="light grey-text center">
            Edit the current website settings
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/website/settings") }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                    <br>
                    <form method="POST">
                        <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
                    <div class="row">
                        <div class="col s12 m6">
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-action-label"></i>
                                </div>
                                <div class="col s8 m9">
                                    <div class="input-field col s10" style="margin-top: 20px;">
                                        <input id="app_name" name="app_name" type="text" value="{{ $settings->app_name }}" class="validate">
                                        <label for="app_name">Website Name</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-social-person"></i>
                                </div>
                                <div class="col s8 m9">
                                    <div class="input-field col s10" style="margin-top: 20px;">
                                        <input id="app_author" name="app_author" type="text" value="{{ $settings->app_author }}" class="validate">
                                        <label for="app_author">Website Owner</label>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="col s12 m6">
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-action-assignment"></i>
                                </div>
                                <div class="col s8 m9">
                                    <div class="col s12 m4">
                                        <p class="flow-text">
                                        Version
                                        </p>
                                    </div>
                                    <div class="col s12 m8">
                                        <p class="range-field" style="margin-top: 30px;">
                                            <input type="range" id="app_version" name="app_version" value="{{ $settings->app_version }}" min="0" max="15" />
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s4 m3 center">
                                    {% if($settings->maintenance == 0) %}
                                    
                                        <i class="medium mdi-action-lock-open"></i>
                                    
                                    {% else %}
                                    
                                        <i class="medium mdi-action-lock-outline"></i>
                                    
                                    {% endif %}
                                </div>
                                <div class="col s8 m9">
                                      <label>Website Status</label>
                                      <select name="maintenance">
                                      
                                        {% if($settings->maintenance == 0) %}

                                            <option value="0" selected>Online</option>
                                            <option value="1">Maintenance</option>

                                        {% else %}

                                            <option value="0">Online</option>
                                            <option value="1" selected>Maintenance</option>

                                        {% endif %}
                                          
                                      </select>
                                </div>
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

<!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>