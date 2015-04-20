<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

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
		$cron_log = new \App\CronLog();
		$cron_log->info = "inspire run";
		$cron_log->save();
		//$this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);

	}

}
