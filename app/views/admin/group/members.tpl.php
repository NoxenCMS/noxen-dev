<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>{{ $group->name }} Members | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            {{ $group->name }} Members
        </h1>
        <h4 class="light grey-text center">
            Current group members
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to("/admin/group/$id") }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>

                    <table class="striped centered">
                        <thead>
                            <tr>
                                <th data-field="username">Username</th>
                                <th data-field="email">Email</th>
                            </tr>
                        </thead>

                        <tbody>
                                <?php
                                    $members = $connection->all('SELECT * FROM groups_users WHERE group_id = ?', [$id]);

                                    foreach($members as $member){
                                        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$member->user_id]);
                                        echo "

                                        <tr>
                                            <td>$user->username</td>
                                            <td>$user->email</td>
                                        </tr>

                                        ";
                                    }
                                ?>
                            {% if(!$members) %}
                            <tr>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            {% endif %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

      <!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>