<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
	
	protected $table = 'customers';
	
	public function package()
	{
		return $this->hasOne('App\Models\Package', 'customer_id');
	}
}
