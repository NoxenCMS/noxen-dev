<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Manage Users | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            Manage Users
        </h1>
        <h4 class="light grey-text center">
            Manage the current registered users in your site
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    
                   <div class="row">
                     <!--<div class="col l12 center">
                        <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/create/user') }}"><i class="mdi-content-add left"></i> Create User</a>
                        <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/groups') }}"><i class="mdi-social-group left"></i> User Groups</a>
                        <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/users/settings') }}"><i class="mdi-action-settings left"></i> User Settings</a>
                    </div> !-->
                    </div>
                    <div class="row">
                        <div class="col s12 m5 l8 center">
                            <a class="btn-floating btn-large waves-effect waves-light" href="{{ $urlBuilder->to('/admin/create/user') }}"><i class="mdi-content-add"></i></a>
                            &nbsp;&nbsp;
                            <a class="btn-floating btn-large waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/groups') }}"><i class="mdi-social-group"></i></a>
                            &nbsp;&nbsp;
                            <a class="btn-floating btn-large waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/users/settings') }}"><i class="mdi-action-settings"></i></a>
                        </div>
                        <form method="POST">
                            <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
                    <div class="col s12 m7 l4 hide-on-small-only" style="margin-top: 5px;">
                        <div class="right">
                        <button style="margin-top: 25px;" class="btn waves-effect waves-light" type="submit" name="action">
    <i class="mdi-content-send"></i>
  </button>
                            </div>
                        <div class="input-field col s9 right">
                    <i class="mdi-action-account-circle prefix"></i>
                    <input name="filter" id="icon_prefix" type="text" class="validate" value="{% if(isset($filter_raw)) %}{{ $filter_raw }}{% endif %}" autofocus>
                    <label for="icon_prefix">Search...</label>
                </div>
                        </form>
                    </div>
                    </div>

                    <table class="striped centered">
                        <thead>
                            <tr>
                                <th data-field="username">Username</th>
                                <th data-field="email">Email</th>
                                <th data-field="created_day">Creation Day</th>
                                <th data-field="activated">Activated</th>
                                <th data-field="banned">Banned</th>
                                <th data-field="options">Profile</th>
                            </tr>
                        </thead>

                        <tbody>

                            {% foreach($users as $user) %}
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    {% if($user->activated == 0) %}
                                        <span class="orange-text">Not Activated</span>
                                    {% else %}
                                        <span class="green-text">Activated</span>
                                    {% endif %}
                                </td>
                                <td>
                                    {% if($user->banned == 0) %}
                                        <span class="green-text">Unbanned</span>
                                    {% else %}
                                        <span class="red-text">Banned</span>
                                    {% endif %}
                                </td>
                                <td><a href="{{ $urlBuilder->to("/admin/user/$user->id") }}" class="btn-floating waves-effect waves-light teal"><i class="mdi-social-person"></i></a></td>
                            </tr>
                            {% endforeach %}

                            {% if(!$users) %}
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            {% endif %}

                        </tbody>
                    </table><br>
                    <div class="center">
                        {% if(isset($filter_raw)) %}
                            <b>Filter: <i>"{{ $filter_raw }}"</i> </b>
                        {% endif %}
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>