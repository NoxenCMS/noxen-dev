<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Login | {{ $settings->app_name }}</title>
    <meta http-equiv="refresh" content="5; url={{ $urlBuilder->to('/admin') }}" />
</head>

<body class="teal darken-2">
    {{ view:'admin/inc/login_menu' }}

<div class="container">
	<div class="row">
		<div class="col s12 m8 offset-m2 l6 offset-l3">
			<div class="white card" style="margin-top: 150px;">
				<div class="card-content center">
              		<span class="card-title black-text">Checking Permissions</span>
              		<p>Please wait...</p>
              		<br>
              		<div class="progress">
				      <div class="indeterminate"></div>
				  </div>
            	</div>
			</div>
            <!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/login_js' }}
		</div>
	</div>
</div>

    </body>
  </html>