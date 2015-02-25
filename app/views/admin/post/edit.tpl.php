<html>
<head>
    <!--Import materialize.css-->
    {{ view:'admin/inc/assets' }}
    <title>Edit Post | {{ $settings->app_name }}</title>
</head>

<body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}
    <div class="header">
        <h1 class="light teal-text center">
            {{ $post->title }}
        </h1>
        <h4 class="light grey-text center">
            Edit Post
        </h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col s12">



                <div class="card-panel white main-content center">
                    <br>
                    <div class="row">
					  <form method="POST" class="col s12">
					  <input name="token" style="display:none" readonly type="text" value="{{ $token }}">
					    <div class="row">
					      <div class="input-field col s6">
					        <i class="mdi-action-account-circle prefix"></i>
					        <input id="title" name="title" type="text" value="{{ $post->title }}" class="validate">
					        <label for="title">Post Title</label>
					      </div>
					      <div class="input-field col s12">
					        <i class="mdi-editor-mode-edit prefix"></i>
					        <textarea id="text" name="text" class="materialize-textarea validate">{{ $post->full_text }}</textarea>
					        <label for="text">Post Content</label>
					      </div>
					    </div>
					</div>
                    <div class="row">
                        <div class="col s6">
                            <a class="btn waves-effect waves-light" href="{{ $urlBuilder->to('/admin/manage/posts') }}">
                            	<i class="mdi-hardware-keyboard-backspace left"></i> Back
                            </a>
                        </div>
                        <div class="col s6">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Update Post
                                <i class="mdi-content-send right"></i>
                            </button>
                        </div>
                            </form>
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