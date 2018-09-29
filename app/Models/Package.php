<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EmailTemplate;
use App\Models\EmailType;
use Mail;
use Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Package extends Model {
	
	protected $table = 'packages';
	
	protected $errors = [];
	
	public function getErrors()
	{
		return $this->errors;
	}
	
	public function customer()
	{
		return $this->belongsTo('App\Models\Customer', 'customer_id');
	}
	
	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}

	public function getDetail()
	{
		$detail = $this->toArray();
		unset($detail['account']);
		unset($detail['password']);
		$detail['settings'] = json_decode($detail['settings'], 1);
		$detail['configs'] = json_decode($detail['configs'], 1);
		return $detail;
	}
	
	public function updateExpiryTime($newExpiryTime)
	{
		$this->expiry_time = $newExpiryTime;
		$this->save();
	}
	
	public function sendEmailInformExtendExpiryTime()
	{
		$template = EmailTemplate::where('type_id', EmailType::where('code', 'email_extend_exp_time')->first()->id)->first();
		if (!$template)
		{
			$this->errors[] = 'Chưa có email template';
		}
		
		if (!empty($this->customer->email))
		{
			$package = $this;
			Mail::send([], [], function ($msg) use ($package, $template) {
				$content = $template->content;
				$content = str_replace('_CUSTOMER_', $package->customer->name, $content);
				$content = str_replace('_SHOP_', $package->name, $content);
				$content = str_replace('_EXPIRY_TIME_', $package->expiry_time, $content);
				$msg->cc(env('BIZ_CC_EMAIL'));
				$msg->to($package->customer->email)->subject($template->title)->setBody($content, 'text/html');
			});
		} else {
			$this->errors[] = 'Không tìm thấy email của gói dịch vụ';
		}
	}
	
	public function activate($isActive = false)
	{
		$this->active = $isActive;
		$this->save();
	}
	
	public function deploy()
	{
		$query = file_get_contents(base_path() . '/tools/addUser.sql.format');
		$query = str_replace('_NAME_', $this->name, $query);
		$query = str_replace('_PHONE_', $this->phone, $query);
		$query = str_replace('_EMAIL_', $this->email, $query);
		$query = str_replace('_ADDRESS_', $this->address, $query);
		$query = str_replace('_CITY_', $this->city, $query);
		$query = str_replace('_ACCOUNT_', $this->account, $query);
		$query = str_replace('_PASSWORD_', md5($this->password), $query);
		file_put_contents(base_path() . '/tools/addUser.sql', $query);
		
		$domainPart = explode('.', $this->domain);
		$dbUsername = $subDomain = strtolower($domainPart[0]);
		$dbPassword = '12346#';
		$dbName = strtolower($this->type . '_' . $subDomain);;
		$type = $this->type;
		$cmd = 'bash ' . base_path() . "/tools/clone_db.sh ". $dbName;
		Log::info('CMD: ' . $cmd);
		$process = new Process($cmd);
		$process->setTimeout(300);
		$process->run();
		if (!$process->isSuccessful()) {
			$this->errors[] = 'Tác vụ sử lý không thành công';
			throw new ProcessFailedException($process);
		}
		$outputMsg = $process->getOutput();
		$this->active = 1;
		$this->installed = 1;
		$this->uptodate_at = date('Y-m-d H:i:s');
		$this->save();
		return $outputMsg;
	}
}
