<?php namespace App\Modules\Customer\Controllers;

use Request;
use Redirect;

use App\Models\Customer;
use App\Models\City;
use App\Models\EmailTemplate;

class CustomerController extends \App\Http\Controllers\Controller {

	public function index()
	{
		$customers = Customer::all();
		return view('customer::index')->with('customers' , $customers);
	}
	
	public function view($id = 0)
	{
		$customer = Customer::find($id);
		if (!$customer) {
			$customer = new Customer();
		}
		$cities = City::getCities();
		return view('customer::view')->with('customer', $customer)->with('cities', $cities);
	}
	
	public function save()
	{
		$inputs = Request::all();
		$customer = Customer::find($inputs['id']);
		if (!$customer) {
			$customer = new Customer();
		}
		$customer->name = $inputs['name'];
		$customer->company = $inputs['company'];
		$customer->address = $inputs['address'];
		$customer->email = $inputs['email'];
		$customer->phone = $inputs['phone'];
		$customer->sex = $inputs['sex'];
		
		$customer->city = $inputs['city'];
		$customer->note = $inputs['note'];
		
		$customer->save();
		return Redirect::to('customer');
	}
	
	public function remove()
	{
		if( Request::ajax() )
		{
			$inputs = Request::all();
			$customer = Customer::find($inputs['id']);
			if ($customer)
			{
				$package = $customer->package;
				if (!empty($package))
				{
					return response()->json(['success' => 0, 'message' => 'Không thể xóa khách hàng đang sử dụng dịch vụ!'], 200);
				} else {
					$customer->delete();
					return response()->json(['success' => 1], 200);
				}
			}
			return response()->json(['success' => 0, 'message' => 'Khách hàng không tồn tại!'], 200);
		}
	}
	
	public function loadModal() {
		if( Request::ajax() )
		{
			$inputs = Request::all();
			$response = ['success' => 0];
			if ($type = $inputs['type'])
			{
				$response['success'] = 1;
				$emailTemplates = EmailTemplate::all();
				$response['modal_html'] = (string) view('customer::partials.modal-send-email-manual')->with('emailTemplates', $emailTemplates);
			}
			return response()->json($response, 200);
		}
	}
}

