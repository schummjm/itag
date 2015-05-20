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
								<th width="150">Date</th>
								<th width="150">Start Time</th>
								<th width="150">End Time</th>
								<th width="150">Tag ID</th>
								<th width="100">Run?</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($actions as $action)
							<tr id="{{ $action->id }}">
								<td>{{ $action->name }}</td>
								<td>{{ $webinar_date }}</td>
								<td>{{ $action->start_time }}</td>
								<td>{{ $action->end_time }}</td>
								<td>{{ $action->tag_id }}</td>
								@if($action->run) 
								<td>YES</td>
								<td><a href="/action/single/{{ $action->webinar_id }}/{{ $action->id }}" class="btn btn-warning">Re-run action</a></td>
								@else
								<td>NO</td>
								<td><a href="/action/single/{{ $action->webinar_id }}/{{ $action->id }}" class="btn btn-success">Run action</a></td>
								@endif 
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
					<div>
						<a href="/action/all/{{$webinar_id}}" class="btn btn-success">Run All Actions</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection