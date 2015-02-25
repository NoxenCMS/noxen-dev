<html>

<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Login | {{ $settings->app_name }}</title>
</head>

<body class="teal darken-2">
    {{ view:'admin/inc/login_menu' }}

<div class="container">
	<div class="row">
		<div class="col s12 m8 offset-m2 l6 offset-l3">
			<div class="white card" style="margin-top: 150px;">
				<div class="card-content center">
              		<span class="card-title black-text">Administration Login</span>
              		<p>In order to access this page, you'll need to login first</p>
              		<br>
              		<form method="POST" class="col s12">
              		<input style="display:none">
					<input type="password" style="display:none">
					<input name="token" style="display:none" readonly type="text" value="{{ $token }}">
					    <div class="row">
				      		<div class="input-field col s12 m6">
					        	<i class="mdi-action-account-circle prefix"></i>
					        	<input id="email" name="email" type="email" class="validate">
					        	<label for="email">Email</label>
			     	 		</div>
					      	<div class="input-field col s12 m6">
					        	<i class="mdi-communication-vpn-key prefix"></i>
					        	<input id="password" name="password" type="password" class="validate">
					        	<label for="password">Password</label>
					      	</div>
				    	</div>
			    	  	<button class="btn waves-effect waves-light" type="submit" name="action">Login
					    	<i class="mdi-content-send right"></i>
					  	</button>
				  	</form>
                    
            	</div>
			</div>
            <!--Import jQuery before materialize.js-->
            {{ view:'admin/inc/login_js' }}
		</div>
	</div>
</div>

    </body>
  </html>