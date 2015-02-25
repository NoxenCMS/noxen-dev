<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>{{ $user->username }} Profile | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            {{ $user->username }}
        </h1>
        <h4 class="light grey-text center">
            User Profile
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <div class="row">
                        <div class="col s12 center">
                        <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/users') }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                    {% if($user->banned == 0) %}
                        <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/user/$user->id/ban") }}"><i class="mdi-action-lock-outline left"></i> Ban User</a>
                    {% else %}
                        <a class="btn waves-effect waves-light o" href="{{ $urlBuilder->to("/admin/user/$user->id/unban") }}"><i class="mdi-action-lock-open left"></i> Un-Ban User</a>
                    {% endif %}
                    
                    {% if($user->activated == 0) %}
                        <a class="btn waves-effect waves-light  " href="{{ $urlBuilder->to("/admin/user/$user->id/activate") }}"><i class="mdi-action-done left"></i> Activate User</a>
                        <a class="btn waves-effect waves-light  " href="{{ $urlBuilder->to("/admin/user/$user->id/resend") }}"><i class="mdi-communication-email left"></i> Resend Code</a>
                    {% else %}
                        <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/user/$user->id/deactivate") }}"><i class="mdi-navigation-close left"></i> Deactivate User</a>
                    {% endif %}
                    
                    <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/user/$user->id/group") }}"><i class="mdi-social-group left"></i> Set group</a>
                    <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/user/$user->id/edit") }}"><i class="mdi-editor-mode-edit left"></i> Edit User</a>
                    
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col s12 m6">
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-social-person"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">{{ $user->username }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-communication-email"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    {% if($user->activated == 0) %}
                                            <i class="medium mdi-action-done"></i>
                                        {% else %}
                                            <i class="medium mdi-action-done-all"></i>
                                        {% endif %}
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">
                                        {% if($user->activated == 0) %}
                                            <span class="orange-text">Not Activated</span>
                                        {% else %}
                                            <span class="green-text">Activated</span>
                                        {% endif %}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-notification-vpn-lock"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">{{ $user->ip }}</p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col s12 m6">
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-device-access-time"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">{{ $user->created_at }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-action-restore"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">{{ $user->updated_at }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s4 m3 center">
                                    {% if($user->banned == 0) %}
                                            <i class="medium mdi-action-lock-open "></i>
                                        {% else %}
                                            <i class="medium mdi-action-lock-outline"></i>
                                        {% endif %}
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">
                                        {% if($user->banned == 0) %}
                                            <span class="green-text">Not Banned</span>
                                        {% else %}
                                            <span class="red-text">Banned</span>
                                        {% endif %}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-social-group"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">
                                        {% if($nogroup == 1) %}
                                        {{ $group->name }}
                                        {% if($group->name == "") %}
                                            No Group
                                        {% endif %}
                                        {% if($group->moderator == 1) %}
                                        <span class="blue-text">[Moderator]</span>
                                        {% endif %}
                                        
                                        {% else %}
                                        <i>No Group</i>
                                        {% endif %}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 center">
                            <a class="btn waves-effect waves-light red" href="{{ $urlBuilder->to("/admin/user/$user->id/delete") }}"><i class="mdi-action-delete left"></i> Delete User</a>
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