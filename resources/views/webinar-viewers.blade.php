@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Webinar Viewers&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/webinar"><small>back to Webinars</small></a></div>

				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th width="100">Contact ID</th>
								<th>Email</th>
								<th width="100">Start Time</th>
								<th width="100">End Time</th>
								<th width="100">Time Spent</th>
								<th>Tags</th>
							</tr>
						</thead>
						<tbody>
							@foreach($viewers as $viewer)
							<tr>
								<td>{{ $viewer->contact_id }}</td>
								<td>{{ $viewer->email }}</td>
								<td>{{ $viewer->start_time }}</td>
								<td>{{ $viewer->end_time }}</td>
								<td>{{ $viewer->time_spent }}</td>
								<td>{{ $viewer->tags }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection