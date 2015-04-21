@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Webinars</div>

				<div class="panel-body">
					@foreach( $webinars as $webinar )
						<div class="row webinar">
							<div class="col-sm-2">
								<button class="btn" type="button">{{ $webinar->webinar_date }}</button>
							</div>
							<div class="col-sm-5">
								<h4>{{ $webinar->webinar_name }}</h4>
							</div>
							<div class="col-sm-5 force-right">
								<a class="btn btn-success" href="/testcmd" target="_blank">Apply Tags</a><a class="btn btn-warning" href="/viewers/{{ $webinar->id}}">Viewers</a><a class="btn btn-info" href="/script/{{ $webinar->id}}">Script</a><a class="btn btn-primary" href="/webinar/{{ $webinar->id }}/edit/">Edit</a>
							</div>
						</div>
						<hr/>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.webinar {
	padding:10px 0px;
	margin:10px 0px;
	border:0px solid #c9c9c9;
}
.webinar a {
	text-decoration:none;
}
.webinar .btn {
	margin-right:10px;
}
.force-right a {
	float:right;
}
.webinar h4 {
	font-size:16px;
}
</style>
@endsection
