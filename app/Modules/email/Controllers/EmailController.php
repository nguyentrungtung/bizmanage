<?php namespace App\Modules\Email\Controllers;

use Request;
use Redirect;
use Mail;

use App\Models\EmailTemplate;
use App\Models\EmailType;
use App\Models\Customer;

class EmailController extends \App\Http\Controllers\Controller {

	public function index()
	{
		$templates = EmailTemplate::all();
		
		return view('email::index')->with('templates' , $templates);
	}
	
	public function view($id = 0)
	{
		$template = EmailTemplate::find($id);
		if (!$template) {
			$template = new EmailTemplate();
		}
		
		$types = EmailType::all();
		return view('email::view')->with('types', $types)->with('template', $template);
	}
	
	public function save()
	{
		$inputs = Request::all();
		$emailTemplate = EmailTemplate::find($inputs['id']);
		if (!$emailTemplate)
		{
			$emailTemplate = new EmailTemplate();
		}
		$emailTemplate->type_id = $inputs['type'];
		$emailTemplate->title = $inputs['email_title'];
		$emailTemplate->content = $inputs['email_content'];
		$emailTemplate->save();
		return Redirect::to('email');
	}
	
	public function active()
	{
		if( Request::ajax() )
		{
			$inputs = Request::all();
			$template = EmailTemplate::find($inputs['template_id']);
			if( !is_null($template) )
			{
				$template->active = $inputs['is_active'];
				$template->save();
			}
			return response()->json(['success' => 1], 200);
		}
	}
	
	public function remove()
	{
		if( Request::ajax() )
		{
			$inputs = Request::all();
			$template = EmailTemplate::find($inputs['template_id']);
			if ($template)
			{
				$template->delete();
			}
			return response()->json(['success' => 1], 200);
		}
	}
	
	public function send() {
		if( Request::ajax() )
		{
			$response = ['success' => 0];
			$inputs = Request::all();
			$template = EmailTemplate::find($inputs['email_template']);
			$customerIds = explode(',', trim($inputs['customer_ids']));
			if (!empty($template) && !empty(trim($inputs['customer_ids']))) {
				$customers = Customer::whereIn('id', $customerIds)->get();
				foreach ($customers as $customer) {
					Mail::send([], [], function ($msg) use ($customer, $template) {
						$template->fulfillment(['customer' => $customer]);
						$msg->to($customer->email)
							->cc(env('BIZ_CC_EMAIL_SUPPORT', ''))
							->subject($template->getTitleFulfillment())
							->setBody($template->getContentFulfillment(), 'text/html');
					});
				}
				
				$response['success'] = 1;
			}
			return response()->json($response, 200);
		}
	}
}

