<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Request;

class WebinarController extends Controller {

	public function cmd() {

		$exitCode = \Artisan::call('inspire');

	}

	public function viewers($webinar_id) 
	{
		$viewers = \App\Viewer::where('webinar_id', '=', $webinar_id)->orderBy('updated_at', 'desc')->get();
		foreach($viewers as $viewer) {
			$f_start_time = date('H:i:s', $viewer->start_time);
			$viewer->start_time = $f_start_time;
			$f_end_time = date('H:i:s', $viewer->end_time);
			$viewer->end_time = $f_end_time;
			$f_time_spent = date('H:i:s', $viewer->time_spent);
			$viewer->time_spent = $f_time_spent;
		}
		return view('webinar-viewers')->withViewers($viewers);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$webinars = \App\Webinar::all();
		return view('home')->withWebinars($webinars);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('webinar');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$webinar = new \App\Webinar();
		$webinar->app_name = $request->input('app_name');
		$webinar->api_key = $request->input('api_key');
		$webinar->webinar_name = $request->input('webinar_name');
		$webinar->webinar_date = $request->input('webinar_date');
		$webinar->save();
		return redirect('/webinar');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$webinar = \App\Webinar::find($id);
		$actions = \App\Action::where('webinar_id', '=', $id)->get();
		return view('webinar-edit')->withWebinar($webinar)->withActions($actions);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{

		$webinar = \App\Webinar::find($id);
		$webinar->app_name = $request->input('app_name');
		$webinar->api_key = $request->input('api_key');
		$webinar->webinar_name = $request->input('webinar_name');
		$webinar->webinar_date = $request->input('webinar_date');
		$webinar->save();

		for ($x = 0; $x < count($request->action_name); $x++) {
			if ($request->action_id[$x] == '') {
				$action = new \App\Action();
			    $action->webinar_id = $id;
			    $action->name = $request->action_name[$x];
			    $action->start_time = $request->start_time[$x];
			    $action->end_time = $request->end_time[$x];
			    $action->tag_id = $request->tag_id[$x];
			    $action->save();
			} else {
				//$time = strtotime($webinar->webinar_date.' '.$request->start_time[$x]);
				//dd($time);
			    $action = \App\Action::find($request->action_id[$x]);
			    $action->webinar_id = $id;
			    $action->name = $request->action_name[$x];
			    $action->start_time = $request->start_time[$x];
			    $action->end_time = $request->end_time[$x];
			    $action->tag_id = $request->tag_id[$x];
			    $action->save();
			}
		}

		return redirect('/webinar/'.$id.'/edit');

	}

	public function delete_action($webinar_id, $action_id) {
		$action = \App\Action::find($action_id);
		$action->delete();
		return redirect('/webinar/'.$webinar_id.'/edit');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
