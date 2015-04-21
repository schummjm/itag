@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Webinar Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/webinar"><small>back to Webinars</small></a></div>

				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>Action Name</th>
								<th width="150">Start Time</th>
								<th width="150">End Time</th>
								<th width="150">Tag ID</th>
								<th width="150">Action Run?</th>
							</tr>
						</thead>
						<tbody>
							@foreach($actions as $action)
							<tr id="{{ $action->id }}">
								<td>{{ $action->name }}</td>
								<td>{{ $action->start_time }}</td>
								<td>{{ $action->end_time }}</td>
								<td>{{ $action->tag_id }}</td>
								<td>
								@if($action->run) 
								YES
								@else
								NO
								@endif 
								</td>
							</tr>
							<script>
								jQuery(document).ready(function() {
									if('{{ $action->run }}' == 1) {
										jQuery('#{{ $action->id }}').css('background-color', '#f9f9f9');
									} else {
										jQuery('#{{ $action->id }}').css('background-color', '#98FB98');
									}
								});
							</script>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection