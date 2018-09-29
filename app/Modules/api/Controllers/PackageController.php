<?php namespace App\Modules\Api\Controllers;

use Request;
use Mail;

use App\Models\Package;
use App\Models\Customer;
use App\Models\Category;
use App\Models\EmailTemplate;
use App\Models\EmailType;

class PackageController extends \App\Http\Controllers\ApiController {

	public function categories($type = '') {
		return response()->json(
			[
				'type' => 'categories',
				'categories' => Category::where('type', $type)->get()
			]
		);
	}
	
	public function detail($domain = '')
	{
		$package = Package::where('domain', $domain)->first();
		if ($package) {
			return response()->json(
				[
					'type' => 'package',
					'data' => $package->getDetail()
				]
			);
		}
		return $this->errorResponse('Resource is not correct!');
	}
	
	public function register() {
		$inputs = Request::all();
		$isValid = true;
		foreach ($inputs as $key => $val) {
			if (empty($val)) {
				$isValid = false;
				break;
			}
		}
		if (!$isValid) {
			return $this->errorResponse('Not enough information provided!');
		}
		$template = EmailTemplate::where('type_id', EmailType::where('code', 'email_confirm')->first()->id)->first();
		if (!$template)
		{
			return $this->errorResponse('General error. Don\'t re-try');
		}
		
		if (Package::where('domain', $inputs['domain'])->exists()) {
			return $this->errorResponse('Domain is already registered');
		}
		/*
		if (!empty($inputs['customer_email']) && Customer::where('email', $inputs['customer_email'])->exists()) {
			return $this->errorResponse('Email is already registered');
		}
		*/
		$customer = new Customer();
		$customer->name = $inputs['customer_name'];
		$customer->email = $inputs['customer_email'];
		$customer->address = $inputs['customer_address'];
		$customer->city = $inputs['customer_city'];
		$customer->phone = $inputs['customer_phone'];
		$customer->save();
		
		$package = new Package();
		$package->category_id = $inputs['category'];
		$package->customer_id = $customer->id;
		$package->type = $inputs['type'];
		$package->name = $inputs['name'];
		$package->domain = strtolower($inputs['domain']);
		$package->account = $inputs['account'];
		$package->password = $inputs['password'];
		$package->expiry_time = date('Y-m-d H:i:s', strtotime('+14 days'));
		$package->active = 0;
		$package->settings = json_encode(['max_location' => 3, 'max_employee' => 20]);

		if ($package->type == 'biz') {
            $prefixPackage = str_replace('.4biz.vn', '', $package->domain);
        } else {
            $prefixPackage = str_replace('.pos.vn', '', $package->domain);
        }
            
		$package->configs = json_encode(['db_name' => $inputs['type'] . '_' . $prefixPackage]);
		$package->save();
		
		if (!empty($package->customer->email))
		{
			Mail::send([], [], function ($msg) use ($package, $template) {
				$template->fulfillment(['package' => $package]);
				$msg->to($package->customer->email)
					->cc(env('BIZ_CC_EMAIL_BOSS', ''))
					->subject($template->getTitleFulfillment())
					->setBody($template->getContentFulfillment(), 'text/html');
			});
			return response()->json(['success' => 1], 200);
		}
		return response()->json(['success' => 1], 200);
	}
}

