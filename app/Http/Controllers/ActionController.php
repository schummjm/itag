<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Response;
use Log;

class ActionController extends Controller {

	public function single( $webinar_id, $action_id ) {

		$webinar = \App\Webinar::find( $webinar_id );

		// set offsets for EST based on Daylight Savings
		if ($webinar->dst) {
			$offset = 4*60*60;
		} else {
			$offset = 5*60*60;
		}
		
		// Set up API
		$app = new \iSDK();
		$app->cfgCon($webinar->app_name, $webinar->api_key);

		// Get all actions that have not been run
		$action = \App\Action::find($action_id);

		// Get webinar date in UTC
		$utc_webinar_date = $webinar->webinar_date + $offset;
		// convert action length to seconds
		$action_length = $action->length*60;
		
		//echo '<br/>Action End Time (EST) '.$action->end_time;
		Log::debug('<br/>Action End Time (EST) '.$action->end_time);
		$end_time = $action->end_time;
		sscanf($end_time, "%d:%d", $hours, $minutes);
		$end_time_seconds = $hours * 3600 + $minutes * 60;
		$end_date_time_seconds = $end_time_seconds + $utc_webinar_date;
		//echo '<br/>Action End Time (UTC) '.date('m/d/Y H:i:s', $end_date_time_seconds).'<br/>';
		Log::debug('<br/>Action End Time (UTC) '.date('m/d/Y H:i:s', $end_date_time_seconds).'<br/>');
		// If end time is past, run actions
		if (time() > $end_date_time_seconds) {
			
			//echo 'before viewers';
			// Start time in seconds
			$start_time = $action->start_time;
			sscanf($start_time, "%d:%d", $hours, $minutes);
			$start_time_seconds = $hours * 3600 + $minutes * 60;
			$start_date_time_seconds = $start_time_seconds + $utc_webinar_date;

			$viewers = \App\Viewer::where('webinar_id', '=', $webinar->id)->get();
			//var_dump($viewers);
			foreach($viewers as $viewer) {
				//echo '<br/>Viewer Info: '.$viewer->contact_id.' | '.$viewer->email.' | '.date('m/d/Y H:i:s', $viewer->start_time).' | '.date('m/d/Y H:i:s', $viewer->end_time).'<br/>';
				Log::debug('<br/>Viewer Info: '.$viewer->contact_id.' | '.$viewer->email.' | '.date('m/d/Y H:i:s', $viewer->start_time).' | '.date('m/d/Y H:i:s', $viewer->end_time).'<br/>');
				if ($viewer->contact_id != null) {
					if ( $viewer->end_time == null ) {
						$viewer->end_time = $end_date_time_seconds;
					}
					if ( $viewer->end_time > $start_date_time_seconds && $viewer->start_time < $end_date_time_seconds ) {
						$length = $viewer->end_time - $viewer->start_time;
						if ($length >= $action_length) {
							$result = $app->grpAssign($viewer->contact_id, $action->tag_id);
							//echo 'Tag Application Infusionsoft Response: '.$result.'<br/>';
							Log::debug('Tag Application Infusionsoft Response: '.$result.'<br/>');
							$viewer->tags = $viewer->tags.$action->tag_id.', ';
							$viewer->save();
						}
					} else {
						//echo 'User Not In Time Frame<br/>';
						Log::debug('User Not In Time Frame<br/>');
					}
				} else {
					//echo 'Error: No Contact Id<br/>';
					Log::debug('Error: No Contact Id<br/>');
				}
			}
			// Mark action as run
			$action->run = 1;
			$action->save();

		}

		return redirect('/actions/'.$webinar_id)->with('success', 'Action Run Successfully!');

	}

	public function all( $webinar_id ) {

		$webinar = \App\Webinar::find( $webinar_id );

		// set offsets for EST based on Daylight Savings
		if ($webinar->dst) {
			$offset = 4*60*60;
		} else {
			$offset = 5*60*60;
		}
		
		// Set up API
		$app = new \iSDK();
		$app->cfgCon($webinar->app_name, $webinar->api_key);

		// Get all actions that have not been run
		$actions = \App\Action::where('webinar_id', '=', $webinar->id)->where('run', '=', 0)->get();
		foreach($actions as $action) {
			
			// Get webinar date in UTC
			$utc_webinar_date = $webinar->webinar_date + $offset;
			// convert action length to seconds
			$action_length = $action->length*60;
			
			//echo '<br/>Action End Time (EST) '.$action->end_time;
			Log::debug('<br/>Action End Time (EST) '.$action->end_time);
			$end_time = $action->end_time;
			sscanf($end_time, "%d:%d", $hours, $minutes);
			$end_time_seconds = $hours * 3600 + $minutes * 60;
			$end_date_time_seconds = $end_time_seconds + $utc_webinar_date;
			//echo '<br/>Action End Time (UTC) '.date('m/d/Y H:i:s', $end_date_time_seconds).'<br/>';
			Log::debug('<br/>Action End Time (UTC) '.date('m/d/Y H:i:s', $end_date_time_seconds).'<br/>');
			// If end time is past, run actions
			if (time() > $end_date_time_seconds) {
				
				//echo 'before viewers';
				// Start time in seconds
				$start_time = $action->start_time;
				sscanf($start_time, "%d:%d", $hours, $minutes);
				$start_time_seconds = $hours * 3600 + $minutes * 60;
				$start_date_time_seconds = $start_time_seconds + $utc_webinar_date;

				$viewers = \App\Viewer::where('webinar_id', '=', $webinar->id)->get();
				//var_dump($viewers);
				foreach($viewers as $viewer) {
					//echo '<br/>Viewer Info: '.$viewer->contact_id.' | '.$viewer->email.' | '.date('m/d/Y H:i:s', $viewer->start_time).' | '.date('m/d/Y H:i:s', $viewer->end_time).'<br/>';
					Log::debug('<br/>Viewer Info: '.$viewer->contact_id.' | '.$viewer->email.' | '.date('m/d/Y H:i:s', $viewer->start_time).' | '.date('m/d/Y H:i:s', $viewer->end_time).'<br/>');
					if ($viewer->contact_id != null) {
						if ( $viewer->end_time == null ) {
							$viewer->end_time = $end_date_time_seconds;
						}
						if ( $viewer->end_time > $start_date_time_seconds && $viewer->start_time < $end_date_time_seconds ) {
							$length = $viewer->end_time - $viewer->start_time;
							if ($length >= $action_length) {
								$result = $app->grpAssign($viewer->contact_id, $action->tag_id);
								//echo 'Tag Application Infusionsoft Response: '.$result.'<br/>';
								Log::debug('Tag Application Infusionsoft Response: '.$result.'<br/>');
								$viewer->tags = $viewer->tags.$action->tag_id.', ';
								$viewer->save();
							}
						} else {
							//echo 'User Not In Time Frame<br/>';
							Log::debug('User Not In Time Frame<br/>');
						}
					} else {
						//echo 'Error: No Contact Id<br/>';
						Log::debug('Error: No Contact Id<br/>');
					}
				}
				// Mark action as run
				$action->run = 1;
				$action->save();

			}
			
		}

		return redirect('/actions/'.$webinar_id);

	}

}

?>