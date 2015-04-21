<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

require_once(app_path().'/Includes/infusionsoft/php-isdk/src/isdk.php');

class Inspire extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'inspire';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Display an inspiring quote';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		// log cron running
		$cron_log = new \App\CronLog();
		$cron_log->info = "cron job run";
		$cron_log->save();

		// Get all current and future webinars
		$webinars = \App\Webinar::where('webinar_date', '>', time()-5-60*60*24)->get();
		foreach($webinars as $webinar) {
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
				
				echo 'Text End Time (EST) '.$action->end_time.'<br/>';
				$end_time = $action->end_time;
				sscanf($end_time, "%d:%d", $hours, $minutes);
				$end_time_seconds = $hours * 3600 + $minutes * 60;
				$end_date_time_seconds = $end_time_seconds + $utc_webinar_date;
				echo 'Date End Time (UTC) ';
				echo date('m/d/Y H:i:s', $end_date_time_seconds);
				echo '<br/>';
				// If end time is past, run actions
				if (time() > $end_date_time_seconds) {
					// Mark action as run
					$action->run = 1;
					$action->save();
					//echo 'before viewers';
					// Start time in seconds
					$start_time = $action->start_time;
					sscanf($start_time, "%d:%d", $hours, $minutes);
					$start_time_seconds = $hours * 3600 + $minutes * 60;
					$start_date_time_seconds = $start_time_seconds + $utc_webinar_date;

					$viewers = \App\Viewer::where('webinar_id', '=', $webinar->id)->get();
					//var_dump($viewers);
					foreach($viewers as $viewer) {
						//echo '<br/><br/>';
						echo $viewer->email.' '.date('m/d/Y H:i:s', $viewer->start_time).' '.date('m/d/Y H:i:s', $viewer->end_time);
						//echo '<br/><br/>';
						if ($viewer->email != null) {
							if ($viewer->end_time == null) {
								$contacts = $app->findByEmail($viewer->email, array('Id'));
								//var_dump($contacts);
								if ($contacts != []) {
									echo $contacts[0]['Id'];
									$app->grpAssign($contacts[0]['Id'], $action->tag_id);
								}
							} else if ( $viewer->end_time > $start_time_seconds ) {
								$contacts = $app->findByEmail($viewer->email, array('Id'));
								//var_dump($contacts);
								if ($contacts != []) {
									echo $contacts[0]['Id'];
									$app->grpAssign($contacts[0]['Id'], $action->tag_id);
								}
							}
						}
					}

				}
				
			}
			
		
		}

		echo 'Tags Applied';

	}

}
