<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Request;

class WebinarController extends Controller {

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
		return view('webinar-edit')->withWebinar($webinar);
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
		return view('webinar-edit')->withWebinar($webinar);
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
