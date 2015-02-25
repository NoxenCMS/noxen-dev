<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>{{ $group->name }} Group | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            {{ $group->name }}
        </h1>
        <h4 class="light grey-text center">
            User Group
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <div class="row">
                        <div class="col s12 m6">
                            <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/groups') }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                            <a class="btn waves-effect waves-light red" href="{{ $urlBuilder->to("/admin/group/$group->id/delete") }}"><i class="mdi-action-delete left"></i> Delete Group</a>
                            <div class="row"><br>
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-communication-vpn-key"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">Group ID: #{{ $group->id }}</p>
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col s4 m3 center">
                                    <i class="medium mdi-social-people"></i>
                                </div>
                                <div class="col s8 m9">
                                    <p class="flow-text">Group Name: {{ $group->name }}
                                        {% if($group->moderator == 1) %}
                                            <span class="blue-text">[MOD]</span>
                                        {% endif %}
                                    </p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col s12 m6 center"><br><br><br><br>
                            <div class="row">
                                <i class="medium mdi-social-people"></i>
                                <h3 class="light">Members: 
                                    {{ $group_members }}<br>
                                    <span class="flow-text"><a href="{{ $urlBuilder->to("/admin/group/$group->id/members") }}">[Member List]</a></span>
                                </h3>
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