<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider {
	
	public function boot()
	{
		$modules = config('modules');
		foreach ($modules as $module => $settings)
		{
		    // Load routes file.
			$coreModuleRoutesPath = app_path('Modules/'.$module.'/routes.php');
			if(is_file($coreModuleRoutesPath))
			{
				include $coreModuleRoutesPath;
			}
			// Load composers file.
			$moduleComposersPath = app_path('Modules/'.$module.'/composers.php');
			if(is_file($moduleComposersPath))
			{
			    include $moduleComposersPath;
			}
            // Load views file.
			$this->loadViewsFrom(app_path('Modules/'.$module.'/Views'), $module);
		}
	}

	public function register()
	{
		
	}

}
