<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Email\Notifier;

class EmailNofitication extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'email:notify';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Email notification.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$notifier = new Notifier();
		
		$notifier->sendDailyWarning();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
