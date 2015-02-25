<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Website Settings | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            Website Settings
        </h1>
        <h4 class="light grey-text center">
            The current website settings
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/website/settings/edit") }}"><i class="mdi-image-edit left"></i> Edit Settings</a>
                    <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/website/footer") }}"><i class="mdi-image-details left"></i> Website Footer</a>
                    <br>
                    <div class="row">
                        <div class="col s12 m6">
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-action-label"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">{{ $settings->app_name }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-social-person"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">{{ $settings->app_author }}</p>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="col s12 m6">
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-action-assignment"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">Version {{ $settings->app_version }}</p>
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
                                    {% if($settings->maintenance == 0) %}
                                    
                                        <p class="flow-text green-text">Online</p>
                                    
                                    {% else %}
                                    
                                        <p class="flow-text orange-text">Maintenance</p>
                                    
                                    {% endif %}
                                </div>
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