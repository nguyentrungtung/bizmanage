<?php namespace App\Http\Middleware;

use Closure;
use App\Models\OfflinePackage;

class VerifyOfflineCode {

	public function handle($request, Closure $next)
	{
		$params = $request->all();
		
		$offlinePackage = OfflinePackage::where('code', $params['code'])->where('expiry_date', '>=', date('Y-m-d H:i:s'))->first();
		
		if ($offlinePackage) {
			return $next($request);
		} else {
			return redirect('offline/404');
		}
	}

}
