@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Webinars</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							Webinar Date
						</div>
						<div class="col-sm-3">
							Webinar Name
						</div>
						<div class="col-sm-3">
							Viewers
						</div>
						<div class="col-sm-3">
							Embed Script
						</div>
					</div>
					@foreach( $webinars as $webinar )
						<div class="row webinar">
							<div class="col-sm-3">
								{{ $webinar->webinar_date }}
							</div>
							<div class="col-sm-3">
								<a href="/webinar/{{ $webinar->id }}/edit/">{{ $webinar->webinar_name }}</a>
							</div>
							<div class="col-sm-3">
								<a href="/viewers/{{ $webinar->id}}">See Viewers</a>
							</div>
							<div class="col-sm-3">
								<a href="/script/{{ $webinar->id}}">View Script</a>
							</div>
						</div>
					
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.webinar {
	padding:20px 0px;
	margin:10px 0px;
	border:1px solid #c9c9c9;
}
.webinar:hover {
	background-color:#f9f9f9;
}
.webinar a {
	text-decoration:none;
}
</style>
@endsection
