<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Manage Groups | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            Manage Groups
        </h1>
        <h4 class="light grey-text center">
            Manage the current user groups
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/users') }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                    <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/create/group') }}"><i class="mdi-social-group-add left"></i> Create Group</a>

                    <table class="striped centered">
                        <thead>
                            <tr>
                                <th data-field="group_id">Group ID</th>
                                <th data-field="group_name">Group Name</th>
                                <th data-field="moderator">Group Type</th>
                                <th data-field="members">Group Members</th>
                                <th data-field="options">Options</th>
                            </tr>
                        </thead>

                        <tbody>
                            {% foreach($groups as $group) %}
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td>{{ $group->name }}</td>
                                <td>
                                    {% if($group->moderator == 0) %}
                                        <span class="green-text">Standard Group</span>
                                    {% else %}
                                        <span class="blue-text">Moderator Group</span>
                                    {% endif %}
                                </td>
                                <td>
                                    <?php
                                        $members = $connection->all('SELECT * FROM groups_users WHERE group_id = ?', [$group->id]);
                                        foreach($members as $member){
                                            $count++;
                                        }
                                        echo $count;
                                        $count = 0;
                                    ?>
                                </td>
                                <td><a href="{{ $urlBuilder->to("/admin/group/$group->id") }}" class="btn-floating waves-effect waves-light teal"><i class="mdi-editor-mode-edit"></i></a></td>
                            </tr>
                            {% endforeach %}
                            
                            {% if(!$groups) %}
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
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