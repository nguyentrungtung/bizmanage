<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	protected $excludeModulePrefix = [
		'api/v1'
	];
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$route = \Route::getRoutes()->match($request);
		if ( !empty($route->getAction()['prefix']) && in_array($route->getAction()['prefix'], $this->excludeModulePrefix)) {
			return $next($request);
		} else {
			return parent::handle($request, $next);
		}
	}

}
