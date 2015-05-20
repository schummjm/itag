@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Webinar Infusionsoft Tagging Options</div>

				<div class="panel-body">
					<form class="form" action="/webinar" method="POST">
						<input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
						<h4>Infusionsoft Info</h4>
						<div class="form-group">
							<label for="app_name">App Name</label>
							<input id="app_name" type="text" class="form-control" name="app_name" placeholder="e.g. ab123" />
						</div>
						<div class="form-group">
							<label for="api_key">API Key</label>
							<input id="api_key" type="text" class="form-control" name="api_key" placeholder="e.g. 4324813921831323432211" />
						</div>
						<a href="#" class="btn btn-primary" id="test">Test Connection</a>
						<hr/>
						<h4>Webinar Info</h4>
						<div class="form-group">
							<label for="webinar_name">Webinar Name</label>
							<input type="text" class="form-control" name="webinar_name" placeholder="" />
						</div>
						<div class="form-group">
							<label for="webinar_date">Webinar Date (MM/DD/YYYY)</label>
							<input placeholer="MM/DD/YYYY" type="date" class="form-control" name="webinar_date" placeholder="" />
						</div>
						<div class="form-group">
							<label for="dst">Daylight Savings Time?</label>
							<input type="checkbox" name="dst" value="1" />
						</div>
						<button type="submit" class="btn btn-primary" style="float:right;">Save Webinar</button>
					</form>
					<a href="/webinar"><button class="btn btn-danger">Cancel</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
small {
	font-size:12px;
}
</style>
<script>
$ = jQuery.noConflict();

	$(function() {
		$("#test").click(function() {
			var app_name = $("input#app_name").val();
			var api_key = $("input#api_key").val();
			var token = $("input#token").val();
			var dataString = 'app_name='+ app_name + '&api_key=' + api_key + '&_token=' + token;
			//alert (dataString);return false;
			$.ajax({
				type: "POST",
				url: "/conn/test",
				data: dataString,
				success: function() {	 
					$('.result').hide();
				    $('<div class="result"><br/><p style="color: #ffffff; background-color: #5cb85c; padding: 6px 12px; font-size: 14px; line-height: 1.42857143;">Connection Successful!</p></div>').insertAfter("#test");
				},
				error: function() {
					$('.result').hide();
					$('<div class="result"><br/><p style="color: #ffffff; background-color: #5cb85c; padding: 6px 12px; font-size: 14px; line-height: 1.42857143; background-color: #d9534f;" >Connection Failed!</p></div>').insertAfter("#test");
				}
			});
			return false;
    });
});
</script>
@stop
