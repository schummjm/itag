<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Request;

class WebinarController extends Controller {

	public function verify(Request $request) 
	{
		$app = new \iSDK();
		//return ;
		if($app->cfgCon($request->app_name, $request->api_key)){
			return 'success';
		}	
	}

	public function actions($webinar_id)
	{
		$actions = \App\Action::where('webinar_id', '=', $webinar_id)->get();
		return view('actions')->withActions($actions)->withWebinar_id($webinar_id);
	}

	public function script($webinar_id) 
	{
		return view('script')->withId($webinar_id);
	}

	public function cmd() {

		$exitCode = \Artisan::call('inspire');

	}

	public function viewers($webinar_id) 
	{
		$webinar = \App\Webinar::find($webinar_id);
		if ($webinar->dst) {
			$offset = 4*60*60;
		} else {
			$offset = 5*60*60;
		}
		$viewers = \App\Viewer::where('webinar_id', '=', $webinar_id)->orderBy('updated_at', 'desc')->get();
		foreach($viewers as $viewer) {
			$f_start_time = date('H:i:s', ($viewer->start_time - $offset));
			$viewer->start_time = $f_start_time;
			if ($viewer->end_time != null) {
				$f_end_time = date('H:i:s', ($viewer->end_time - $offset));
				$viewer->end_time = $f_end_time;
				$f_time_spent = date('H:i:s', $viewer->time_spent);
				$viewer->time_spent = $f_time_spent;
			}
			
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
		$webinars = \App\Webinar::orderBy('webinar_date', 'desc')->get();
		foreach($webinars as $webinar) {
			$f_date = date('m/d/Y', $webinar->webinar_date);
			$webinar->webinar_date = $f_date;
		}
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
		$webinar->webinar_date = strtotime($request->input('webinar_date'));
		$webinar->dst = $request->input('dst');
		$webinar->save();
		return redirect('/webinar/'.$webinar->id.'/edit');
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
		$f_date = date('Y-m-d', $webinar->webinar_date);
		$webinar->webinar_date = $f_date;
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
		$webinar->webinar_date = strtotime($request->input('webinar_date'));
		$webinar->dst = $request->input('dst');
		$webinar->save();

		for ($x = 0; $x < count($request->action_name); $x++) {
			if ($request->action_id[$x] == '') {
				$action = new \App\Action();
			    $action->webinar_id = $id;
			    $action->name = $request->action_name[$x];
			    $action->start_time = $request->start_time[$x];
			    $action->end_time = $request->end_time[$x];
			    $action->length = $request->length[$x];
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
			    $action->length = $request->length[$x];
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
