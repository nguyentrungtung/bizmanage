<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model {
	
	protected $table = 'email_templates';
	
	protected $content_fulfillment = '';
	
	protected $title_fulfillment = '';
	
	public function getContentFulfillment() {
		return !empty($this->content_fulfillment) ? $this->content_fulfillment : $this->content;
	}
	
	public function getTitleFulfillment() {
		return !empty($this->title_fulfillment) ? $this->title_fulfillment : $this->title;
	}
	
	public function type()
	{
		return $this->belongsTo('App\Models\EmailType', 'type_id');
	}
	
	public function fulfillment($params = []) {
		$customer = $package = null;
		
		if (!empty($params['customer'])) {
			$customer = $params['customer'];
			$package = $customer->package;
		} else if (!empty($params['package'])) {
			$package = $params['package'];
			$customer = $package->customer;
		}
		
		$contentFulfillment = $this->content;
		$titleFulfillment = $this->title;
		
		if ($package) {
			$packageLink = '<a href="'. url('/') .'/package/confirm?id='. $package->id .'&token='. md5($package->id . env('APP_KEY')) .'">tại đây</a>';
			$contentFulfillment = str_replace('_LINK_', $packageLink, $contentFulfillment);
			$contentFulfillment = str_replace('_SHOP_', $package->name, $contentFulfillment);
			$contentFulfillment = str_replace('_PACKAGE_NAME_', $package->name, $contentFulfillment);
			$contentFulfillment = str_replace('_ACCOUNT_', $package->account, $contentFulfillment);
			$contentFulfillment = str_replace('_PASSWORD_', $package->password, $contentFulfillment);
			//$contentFulfillment = str_replace('_EXPIRY_TIME_DEFAULT_', $package->expiry_time, $contentFulfillment);
			
			$contentFulfillment = str_replace('_EXPIRY_TIME_', date('H:i:s d/m/Y', strtotime($package->expiry_time)), $contentFulfillment);
			
			$titleFulfillment = str_replace('_SHOP_', $package->name, $titleFulfillment);
		}
		
		if ($customer) {
			$contentFulfillment = str_replace('_CUSTOMER_NAME_', $customer->name, $contentFulfillment);
			$contentFulfillment = str_replace('_CUSTOMER_COMPANY_', $customer->company, $contentFulfillment);
			$titleFulfillment = str_replace('_CUSTOMER_NAME_', $customer->name, $titleFulfillment);
		}
		
		$this->content_fulfillment = $contentFulfillment;
		$this->title_fulfillment = $titleFulfillment;
	}
}
