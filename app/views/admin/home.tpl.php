<?php

?>
<html>
    <head>
      <!--Import materialize.css-->
      {{ view:'admin/inc/assets' }}
    </head>

        <body class="grey lighten-3">
    {{ view:'admin/inc/menu' }}

        <div class="container">
            <div class="row" style="margin-top: 50px;">
                <div class="col s12 m6 offset-m3">
                    
                    {% foreach($json->news as $data) %}
                        <div class="card-panel white">
                            <h4 class="light">{{ $data->title }} <small><?php echo date('d F Y', strtotime($data->created_at)) ?></small></h4>
                            <p>{{ $data->content }}</p>
                        </div>
                    {% endforeach %}

                </div>
            </div>
        </div>
        
<!--Import jQuery before materialize.js-->
    {{ view:'admin/inc/js' }}
    </body>
  </html>