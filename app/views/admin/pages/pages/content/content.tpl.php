<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>{{ $content->name }} | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            {{ $content->name }} Content
        </h1>
        <h4 class="light grey-text center">
            Content Information
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">

                <div class="card-panel white main-content">
                
                <div class="row">
                    <div class="col s12 center">
                <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to("/admin/pages/$page->id") }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to("/admin/pages/$page->id/$content->id/edit") }}"><i class="mdi-editor-mode-edit left"></i> Edit Content</a>
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
                                    <p class="flow-text">{{ $content->name }}
                                    </p>
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
                                    <p class="flow-text">{{ $content->content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col s12 center">
                <a class="btn waves-effect waves-light red" href="{{ $urlBuilder->to("/admin/pages/$page->id/$content->id/delete") }}"><i class="mdi-action-delete left"></i> Delete Content</a>
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