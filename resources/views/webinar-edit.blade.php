@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Webinar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/webinar"><small>back to Webinars</small></a><a href="/webinar/delete/{{$webinar->id}}" class="btn btn-danger" style="float:right; padding-top:3px; padding-bottom:3px; font-size:10px;">Delete Webinar</a></div>

				<div class="panel-body">
					<form class="form" action="/webinar/{{ $webinar->id }}" method="POST">
						<input type="hidden" name="_method" value="PUT">
						<input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
						<h4>Infusionsoft Info</h4>
						<div class="form-group">
							<label for="app_name">App Name</label>
							<input id="app_name" type="text" class="form-control" name="app_name" placeholder="e.g. ab123" value="{{ $webinar->app_name }}" />
						</div>
						<div class="form-group">
							<label for="api_key">API Key</label>
							<input id="api_key" type="text" class="form-control" name="api_key" placeholder="e.g. 4324813921831323432211" value="{{ $webinar->api_key }}" />
						</div>
						<a href="#" class="btn btn-primary" id="test">Test Connection</a>
						<hr/>
						<h4>Webinar Info</h4>
						<div class="form-group">
							<label for="webinar_name">Webinar Name</label>
							<input type="text" class="form-control" name="webinar_name" placeholder="" value="{{ $webinar->webinar_name }}" />
						</div>
						<div class="form-group">
							<label for="webinar_date">Webinar Date (MM/DD/YYYY)</label>
							<input placeholer="MM/DD/YYYY" type="date" class="form-control" name="webinar_date" placeholder="" value="{{ $webinar->webinar_date }}" />
						</div>
						<div class="form-group">
							<label for="dst">Daylight Savings Time?</label>
							<input type="checkbox" name="dst" id="dst" value="1" />
						</div>
						<hr/>
						<h4>Actions <span style="font-size:12px;">(will apply Infusionsoft tag if a person is present on the webinar during the time frame and for the given length)</span></h4>
						@foreach($actions as $action)
						<input type="hidden" name="action_id[]" value="{{ $action->id }}">
						<div class="row action">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Action Name</label>
									<input type="text" class="form-control" name="action_name[]" placeholder="" required value="{{ $action->name }}" />
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Start Time (EST)</label>
									<input placeholder="HH:MM" type="time" class="form-control" name="start_time[]" placeholder="" required value="{{ $action->start_time }}" />
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>End Time (EST)</label>
									<input placeholder="HH:MM" type="time" class="form-control" name="end_time[]" placeholder="" required value="{{ $action->end_time }}" />
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Length (minutes)</label>
									<input type="text" class="form-control" name="length[]" placeholder="" required value="{{ $action->length }}" />
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Tag Id</label>
									<input type="text" class="form-control" name="tag_id[]" placeholder="" required value="{{ $action->tag_id }}" />
								</div>
							</div>
							<div class="col-sm-1">
								<div class="form-group">
									<a href="/action/delete/{{ $webinar->id }}/{{ $action->id }}" class="btn btn-danger" style="margin-top:24px; padding-left:5px; padding-right:5px;">Delete</a>
								</div>
							</div>
						</div>
						@endforeach
						<button type="button" class="btn btn-warning" id="more-actions">Add Another Action</button>
						<hr/>
						<button type="submit" class="btn btn-primary" style="float:right;">Save Webinar</button>
					</form>
					<a href="/webinar"><button class="btn btn-danger">Cancel</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.action {
	margin-bottom:10px;
}
</style>
<script>
jQuery(document).ready(function() {
	if('{{ $webinar->dst }}' == 1) {
		jQuery('#dst').attr('checked', 'true');
	}
	var i = 1;
	jQuery('#more-actions').on('click', function() {

		jQuery('<div class="row action" id="'+i+'"><input type="hidden" name="action_id[]" value=""><div class="col-sm-3"><div class="form-group"><label>Action Name</label><input type="text" class="form-control" name="action_name[]" placeholder="" required /></div></div><div class="col-sm-2"><div class="form-group"><label>Start Time (EST)</label><input placeholder="HH:MM" type="time" class="form-control" name="start_time[]" placeholder="" required /></div></div><div class="col-sm-2"><div class="form-group"><label>End Time (EST)</label><input placeholder="HH:MM" type="time" class="form-control" name="end_time[]" placeholder="" required /></div></div><div class="col-sm-2"><div class="form-group"><label>Length (minutes)</label><input type="text" class="form-control" name="length[]" placeholder="" required /></div></div><div class="col-sm-2"><div class="form-group"><label>Tag Id</label><input type="text" class="form-control" name="tag_id[]" placeholder="" required /></div></div><div class="col-sm-1"><div class="form-group"><button class="btn btn-danger"  type="button" style="margin-top:24px; padding-left:5px; padding-right:5px;" onClick="deleteMe(\'#'+i+'\')">Delete</button></div></div></div>').insertBefore('#more-actions');
		i++;

	});
});
function deleteMe(theid) {
	jQuery(theid).hide();
}
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
@endsection
