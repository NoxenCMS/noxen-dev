			<div class="white card">
				<div class="card-content center">
              		<p>Copyright &copy; {{ date("Y") }} {{ $settings->app_name }} {{ $settings->app_version }}</p> 
            	</div>
			</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="{{ $urlBuilder->to('/assets/admin/js/materialize.js') }}"></script>
<script>
    $(document).ready(function () {
        // Initialize collapse button
        $(".button-collapse").sideNav();
        // Initialize collapsible
        $('.collapsible').collapsible();
        //Initialize select element
        $('select').material_select();
    });
</script>