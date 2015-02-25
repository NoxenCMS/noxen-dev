<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>{{ $page->name }} Content | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text  center">
            {{$page->name}} Content
        </h1>
        <h4 class="light grey-text center">
            Manage the {{$page->name}} content
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel white main-content">
                    
                   <div class="row">
                     <!--

                     <div class="col l12 center">
                        <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/create/user') }}"><i class="mdi-content-add left"></i> Create User</a>
                        <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/groups') }}"><i class="mdi-social-group left"></i> User Groups</a>
                        <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/users/settings') }}"><i class="mdi-action-settings left"></i> User Settings</a>
                    </div>

                    !-->
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/pages') }}"><i class="mdi-hardware-keyboard-backspace left"></i> Back</a>
                            <a class="btn waves-effect waves-light " href="{{ $urlBuilder->to("/admin/pages/$page->id/create") }}"><i class="mdi-content-add left"></i> Create Content</a>
<!--

<a class="btn-floating btn-large waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/post/settings') }}"><i class="mdi-action-settings"></i></a>

!-->
                        </div>



                    <table class="striped centered ">
                        <thead>
                            <tr>
                                <th data-field="id">ID</th>
                                <th data-field="title">Name</th>
                                <th data-field="options">Options</th>
                            </tr>
                        </thead>

                        <tbody>

                            {% foreach($contents as $content) %}
                            <tr>
                                <td># {{ $content->id }}</td>
                                <td>{{ $content->name }}</td>
                                <td><a href="{{ $urlBuilder->to("/admin/pages/$page->id/$content->id") }}" class="btn-floating waves-effect waves-light teal"><i class="mdi-image-edit"></i></a></td>
                            </tr>
                            
                            {% endforeach %}
                            
                            {% if(!$contents) %}
                            <tr>
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
    </div>

    <!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>