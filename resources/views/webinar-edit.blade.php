@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Webinar Infusionsoft Tagging Options</div>

				<div class="panel-body">
					<form class="form" action="/webinar/{{ $webinar->id }}" method="POST">
						<input type="hidden" name="_method" value="PUT">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<h4>Infusionsoft Info</h4>
						<div class="form-group">
							<label for="app_name">App Name</label>
							<input type="text" class="form-control" name="app_name" placeholder="e.g. ab123" value="{{ $webinar->app_name }}" />
						</div>
						<div class="form-group">
							<label for="api_key">API Key</label>
							<input type="text" class="form-control" name="api_key" placeholder="e.g. 4324813921831323432211" value="{{ $webinar->api_key }}" />
						</div>
						<hr/>
						<h4>Webinar Info</h4>
						<div class="form-group">
							<label for="webinar_name">Webinar Name</label>
							<input type="text" class="form-control" name="webinar_name" placeholder="" value="{{ $webinar->webinar_name }}" />
						</div>
						<div class="form-group">
							<label for="webinar_date">Webinar Date</label>
							<input type="date" class="form-control" name="webinar_date" placeholder="" value="{{ $webinar->webinar_date }}" />
						</div>
						<hr/>
						<h4>Actions <span style="font-size:12px;">(will apply Infusionsoft tag if a person is NOT present on the webinar during the time frame)</span></h4>
						<div class="row">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Action Name</label>
											<input type="text" class="form-control" name="action_name" placeholder="" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Start Time</label>
											<input type="time" class="form-control" name="start_time" placeholder="" />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>End Time</label>
											<input type="time" class="form-control" name="end_time" placeholder="" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Infusionsoft Tag Name (for reference)</label>
											<input type="text" class="form-control" name="tag_name" placeholder="" />
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Infusionsoft Tag Id</label>
											<input type="text" class="form-control" name="tag_id" placeholder="" />
										</div>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary" style="float:right;">Save Webinar</button>
					</form>
					<a href="/webinar"><button class="btn btn-danger">Cancel</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
