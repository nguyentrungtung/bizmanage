<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Models\Package;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BuildPackage extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'package:build';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Build a new package';

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
		$domain = $this->argument('domain');
		$package = Package::where('domain', $domain)->first();
		if ($package) {
			$query = file_get_contents(base_path() . '/tools/addUser.sql.format');
			$query = str_replace('_NAME_', $package->name, $query);
			$query = str_replace('_PHONE_', $package->phone, $query);
			$query = str_replace('_EMAIL_', $package->email, $query);
			$query = str_replace('_ADDRESS_', $package->address, $query);
			$query = str_replace('_CITY_', $package->city, $query);
			$query = str_replace('_ACCOUNT_', $package->account, $query);
			$query = str_replace('_PASSWORD_', md5($package->password), $query);
			file_put_contents(base_path() . '/tools/addUser.sql', $query);
			
			$domainPart = explode('.', $package->domain);
			$subDomain = strtolower($domainPart[0]);
			$dbUsername = $domainPart[0];
			$dbPassword = '12346#';
			$dbName = $domainPart[0];
			$type = $package->type;
			$cmd = 'bash ' . base_path() . "/tools/auto_build_site.sh ". $type ." " .strtolower($package->domain). " $dbUsername $dbPassword $dbName";
			$process = new Process($cmd);
			$process->setTimeout(null);
			$process->run();
			if (!$process->isSuccessful()) {
				$this->errors[] = 'Tác vụ sử lý không thành công';
				throw new ProcessFailedException($process);
			}
			$outputMsg = $process->getOutput();
			$package->active = 1;
			$package->installed = 1;
			$package->uptodate_at = date('Y-m-d H:i:s');
			$package->save();
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['domain', InputArgument::REQUIRED, 'Domain of package.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
