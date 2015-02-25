<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Website Footer | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            Website Footer
        </h1>
        <h4 class="light grey-text center">
            The current website footer
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/website/settings") }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                    <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/website/footer/edit") }}"><i class="mdi-image-edit left"></i> Edit Footer</a>
                    <br>
                    <div class="row">
                        <div class="col s12 m12">
                            
                            <div class="row">
                                <div class="col s4 m3 l2 center">
                                    <i class="medium mdi-action-label"></i>
                                </div>
                                <div class="col s8 m9 l10">
                                    <p class="flow-text">{{ $footer->title }}</p>
                                </div>
                            </div>   
                            
                            <div class="row">
                                <div class="col s4 m3 l2 center">
                                    <i class="medium mdi-notification-sms"></i>
                                </div>
                                <div class="col s8 m9 l10">
                                    <p class="flow-text">{{ $footer->bio }}</p>
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