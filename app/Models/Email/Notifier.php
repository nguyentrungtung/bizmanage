<?php namespace App\Models\Email;

use Mail;
use App\Models\Package;
use App\Models\EmailTemplate;
use App\Models\EmailType;

use Carbon\Carbon;

class Notifier {
	
	public function sendDailyWarning () 
	{
		$now = Carbon::now();
		$trialExpiresWarning = $now->addDays(3);
		$packages = Package::where('expiry_time', '>=', date('Y-m-d H:i:s', strtotime('now')))->where('expiry_time', '<', $trialExpiresWarning)->get();
		$template = EmailTemplate::where('type_id', EmailType::where('code', 'email_warning')->first()->id)->first();
		if ($template) {
			foreach ($packages as $package) {
				if ($package && !empty($package->customer->email)) {
					Mail::send([], [], function ($msg) use ($package, $template) {
						$expiryTime = Carbon::parse($package->expiry_time);
						$content = $template->content;
						$packageLink = '<a href="'. url('/') .'/package/confirm?id='. $package->id .'&token='. md5($package->id . env('APP_KEY')) .'">tại đây</a>';
						$content = str_replace('_DAYS_', $expiryTime->diffInDays(), $content);
						$content = str_replace('_MINUTES_ ', $expiryTime->diffInMinutes(), $content);
						$content = str_replace('_SHOP_', $package->name, $content);
						$content = str_replace('_ACCOUNT_', $package->account, $content);
						$content = str_replace('_PASSWORD_', $package->password, $content);
						$msg->to($package->customer->email)->subject($template->title)->setBody($content, 'text/html');
					});
				}
			}
		}
	}
}