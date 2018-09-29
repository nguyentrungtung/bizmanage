<?php namespace App\Http\Middleware;

use Closure;

class ApiAuthenticate {

	public function handle($request, Closure $next)
	{
		$apiKey = $request->header('apikey', '');
		if ($apiKey == config('app.api_key')) {
			return $next($request);
		} else {
			return response()->json(
				['type' => 'error', 'message' => 'Authentication failed']
			);
		}
	}

}
