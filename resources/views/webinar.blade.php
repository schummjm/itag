@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Webinar Infusionsoft Tagging Options</div>

				<div class="panel-body">
					<form class="form" action="/webinar" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<h4>Infusionsoft Info</h4>
						<div class="form-group">
							<label for="app_name">App Name</label>
							<input type="text" class="form-control" name="app_name" placeholder="e.g. ab123" />
						</div>
						<div class="form-group">
							<label for="api_key">API Key</label>
							<input type="text" class="form-control" name="api_key" placeholder="e.g. 4324813921831323432211" />
						</div>
						<hr/>
						<h4>Webinar Info</h4>
						<div class="form-group">
							<label for="webinar_name">Webinar Name</label>
							<input type="text" class="form-control" name="webinar_name" placeholder="" />
						</div>
						<div class="form-group">
							<label for="webinar_date">Webinar Date</label>
							<input type="date" class="form-control" name="webinar_date" placeholder="" />
						</div>
						<div class="form-group">
							<label for="dst">Daylight Savings Time?</label>
							<input type="checkbox" name="dst" />
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
@endsection
