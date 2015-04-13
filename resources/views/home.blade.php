@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Webinars</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-sm-6">
							Webinar Name
						</div>
						<div class="col-sm-6">
							Webinar Date
						</div>
					</div>
					@foreach( $webinars as $webinar )
					<a href="/webinar/{{ $webinar->id }}/edit/">
						<div class="row webinar">
							<div class="col-sm-6">
								{{ $webinar->webinar_name }}
							</div>
							<div class="col-sm-6">
								{{ $webinar->webinar_date }}
							</div>
						</div>
					</a>
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
	cursor:pointer;
}
.webinar:hover {
	background-color:#f9f9f9;
}
</style>
@endsection
