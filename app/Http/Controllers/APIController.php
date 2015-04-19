<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Response;

class APIController extends Controller {

	public function start($webinar_id, $email) {
		$viewer = new \App\Viewer();
		$viewer->webinar_id = $webinar_id;
		$viewer->email = $email;
		$viewer->start_time = time();
		$viewer->save();
		return Response::json(array('success' => true))->setCallback($_GET['callback']);
	}

	public function end($webinar_id, $email) {
		$viewer = \App\Viewer::where('webinar_id', '=', $webinar_id)->where('email', '=', $email)->orderBy('created_at', 'desc')->first();
		$viewer->end_time = time();
		$viewer->time_spent = time() - $viewer->start_time;
		$viewer->save();
		return Response::json(array('success' => true))->setCallback($_GET['callback']);
	}




	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
