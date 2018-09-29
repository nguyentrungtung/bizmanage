<?php
namespace App\Modules\Package\Controllers;

use Response;
use Request;
use Mail;
use Redirect;
use Log;
use Validator;
use App\Models\Package;
use App\Models\Category;
use App\Models\OfflinePackage;
use App\Models\EmailTemplate;
use App\Models\EmailType;
use App\Models\Customer;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PackageController extends \App\Http\Controllers\Controller
{

    public function __construct()
    {
        $this->middleware('verify.offline.code', [
            'only' => [
                'offline'
            ]
        ]);
    }

    public function view($id = 0)
    {
        $package = Package::find($id);
        $categories = Category::all();
        if (!$package) {
            return view('package::add')->with('categories', $categories);
        } else {
            return view('package::view')->with('package', $package)->with('categories', $categories);
        }
    }

    public function uptodate()
    {
        $inputs = Request::all();
        $package = Package::find($inputs['id']);
        
        if ($package) {
            $configs = json_decode($package->configs, TRUE);
            if ($package->type == 'biz') {
                $prefixPackage = str_replace('.4biz.vn', '', $package->domain);
            } else {
                $prefixPackage = str_replace('.pos.vn', '', $package->domain);
            }
            $dbName = !empty($configs['db_name']) ? $configs['db_name'] : $prefixPackage;
            if ($package->internal) {
                $cmd = 'bash ' . base_path() . "/tools/uptodate_staging.sh ". $package->type ." " . $package->domain . " " . $dbName;
            } else {
                if ($package->is_custom) {
                    $cmd = 'bash ' . base_path() . "/tools/uptodate_production_custom.sh ". $package->type ." " . $package->domain . " " . $dbName;
                } else {
                    $cmd = 'bash ' . base_path() . "/tools/uptodate_production.sh ". $package->type ." " . $package->domain . " " . $dbName;
                }
            }
            
            $process = new Process($cmd);
            $process->run();
            if (!$process->isSuccessful()) {
                $this->errors[] = 'Tác vụ sử lý không thành công';
                throw new ProcessFailedException($process);
            }
            $package->uptodate_at = date('Y-m-d H:i:s');
            $package->save();
        }
        return response()->json([
            'success' => 1,
            'cmd' => $cmd,
            'message' => $process->getOutput()
        ], 200);
    }

    public function save()
    {
        $inputs = Request::all();
        $package = Package::find($inputs['id']);
        if ($package) {
            $package->is_custom = !empty($inputs['is_custom']) ? $inputs['is_custom'] : '0';
            $package->settings = $inputs['settings'];
            $package->save();
        } else {
            $v = Validator::make($inputs, [
                'customer_email' => 'required|email',
                'domain' => 'required'
            ]);
            
            if ($v->fails()) {
                return Redirect::to('package/view/-1')->withErrors($v->errors());
            } else {
                if (!Package::where('domain', $inputs['domain'])->exists()) {
                    $customer = new Customer();
                    $customer->name = $inputs['customer_name'];
                    $customer->email = $inputs['customer_email'];
                    $customer->address = $inputs['customer_address'];
                    $customer->phone = $inputs['customer_phone'];
                    $customer->city = 'Hà Nội';
                    $customer->save();
                    
                    $package = new Package();
                    $package->category_id = $inputs['category'];
                    $package->customer_id = $customer->id;
                    $package->type = $inputs['type'];
                    $package->name = $inputs['shop_name'];
                    $package->domain = strtolower($inputs['domain']) . '.4biz.vn';
                    $package->account = $inputs['account'];
                    $package->password = $inputs['password'];
                    $package->expiry_time = date('Y-m-d H:i:s', strtotime('+14 days'));
                    $package->uptodate_at = date('Y-m-d H:i:s');
                    $package->active = 0;
                    $package->configs = json_encode(['db_name' => $inputs['type'] . '_' . strtolower($inputs['domain'])]);
                    $package->save();
                    Log::info('BEGIN DEPLOY: ===');
                    $outputMsg = '';
                    $outputMsg = $package->deploy();
                    Log::info('ERROR: ' . $outputMsg);
                    Log::info('END DEPLOY: ' . $outputMsg);
                }
            }
        }
        return Redirect::to('package/list/online');
    }

    public function index($mode = 'online')
    {
        if ($mode == 'internal') {
            $packages = Package::where('internal', 1)->whereNull('deleted_at');
        } else {
            $packages = Package::where('internal', 0)->whereNull('deleted_at');
        }
        return view('package::index')->with('packages', $packages->get());
    }

    public function offline()
    {
        return Response::download(env('OFFLINE_PACKAGE_FILE', '/vagrant/homestead.zip'), 'offline.zip', [
            'Content-type: force-download'
        ]);
    }

    public function extend()
    {
        if (Request::ajax()) {
            $inputs = Request::all();
            $package = Package::find($inputs['id']);
            if (!empty($package)) {
                $package->updateExpiryTime($inputs['expiry_time_new']);
                $package->sendEmailInformExtendExpiryTime();
            }
            
            if (!empty($package->getErrors())) {
                return response()->json([
                    'success' => 0,
                    'errors' => $package->getErrors()
                ], 200);
            }
            return response()->json([
                'success' => 1
            ], 200);
        }
    }

    public function active()
    {
        if (Request::ajax()) {
            $inputs = Request::all();
            $package = Package::find($inputs['id']);
            if (!empty($package)) {
                $package->activate((boolean) $inputs['is_active']);
            }
            
            if (!empty($package->getErrors())) {
                return response()->json([
                    'success' => 0,
                    'errors' => $package->getErrors()
                ], 200);
            }
            
            return response()->json([
                'success' => 1
            ], 200);
        }
    }

    public function register()
    {
        $categories = Category::all();
        return view('package::register')->with('categories', $categories);
    }

    public function confirm()
    {
        $inputs = Request::all();
        $package = Package::find($inputs['id']);
        return view('package::confirm')->with('inputs', $inputs)->with('package', $package);
    }
    
    public function deploy() 
    {
        $inputs = Request::all();
        $package = Package::find($inputs['id']);
        $outputMsg = '';
        $success = 0;
        $message = '';
        
        if ($package && $inputs['token'] == md5($package->id . env('APP_KEY'))) {
            if (!$package->installed) {
                $outputMsg = $package->deploy();
            }
            $success = 1;
        } else {
            $message = 'Dữ liệu về package hoặc token không chính xác!';
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    public function create()
    {
        if (Request::ajax()) {
            $isValid = true;
            $inputs = Request::all();
            foreach ($inputs as $key => $val) {
                if (empty($val)) {
                    $isValid = false;
                    break;
                }
            }
            if (!$isValid) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Thông tin dịch vụ chưa điền đầy đủ'
                ], 200);
            }
            
            if (!Package::where('domain', $inputs['domain'])->exists()) {
                if (1 || !Customer::where('email', $inputs['email'])->exists()) {
                    
                    $customer = new Customer();
                    $customer->name = $inputs['shop_name'];
                    $customer->email = $inputs['email'];
                    $customer->address = $inputs['address'];
                    $customer->city = $inputs['city'];
                    $customer->save();
                    
                    $package = new Package();
                    $package->category_id = $inputs['category'];
                    $package->customer_id = $customer->id;
                    $package->name = $inputs['shop_name'];
                    $package->domain = strtolower($inputs['domain']);
                    $package->account = $inputs['account'];
                    $package->password = $inputs['password'];
                    $package->expiry_time = date('Y-m-d H:i:s', strtotime('+14 days'));
                    $package->uptodate_at = date('Y-m-d H:i:s');
                    $package->active = 0;
                    $package->save();
                    
                    $template = EmailTemplate::where('type_id', EmailType::where('code', 'email_confirm')->first()->id)->first();
                    if (!$template) {
                        return response()->json([
                            'success' => 0,
                            'message' => 'Chưa có email template'
                        ], 200);
                    }
                    
                    if (!empty($package->customer->email)) {
                        Mail::send([], [], function ($msg) use ($package, $template) {
                            $content = $template->content;
                            $packageLink = '<a href="' . url('/') . '/package/confirm?id=' . $package->id . '&token=' . md5($package->id . env('APP_KEY')) . '">tại đây</a>';
                            $content = str_replace('_LINK_', $packageLink, $content);
                            $content = str_replace('_SHOP_', $package->name, $content);
                            $content = str_replace('_ACCOUNT_', $package->account, $content);
                            $content = str_replace('_PASSWORD_', $package->password, $content);
                            $msg->to($package->customer->email)
                                ->subject($template->title)
                                ->setBody($content, 'text/html');
                        });
                        return response()->json([
                            'success' => 1
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'success' => 0,
                        'message' => 'Email đã được đăng ký'
                    ], 200);
                }
            } else {
                return response()->json([
                    'success' => 0,
                    'message' => 'Domain đã được đăng ký'
                ], 200);
            }
        }
    }

    public function success()
    {
        return view('package::success');
    }

    public function offlineGenerateCode()
    {
        if (Request::ajax()) {
            $inputs = Request::all();
            
            $offlinePackage = new OfflinePackage();
            $customer = Customer::find($inputs['customer_id']);
            $package = $customer->package;
            $offlinePackage->customer_id = $inputs['customer_id'];
            $offlinePackage->package_id = $package->id;
            $offlinePackage->code = md5('customer_' . $offlinePackage->customer_id . '#package_' . $offlinePackage->package_id . '#TIME_' . time());
            $offlinePackage->expiry_date = date('Y-m-d H:i:s', strtotime('+3 days'));
            ;
            $offlinePackage->save();
            
            $template = EmailTemplate::where('type_id', EmailType::where('code', 'email_generate_offline_code')->first()->id)->first();
            if (!$template) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Chưa có email template'
                ], 200);
            }
            
            if (!empty($customer->email)) {
                Mail::send([], [], function ($msg) use ($offlinePackage, $package, $template) {
                    $content = $template->content;
                    $packageLink = '<a href="' . url('/') . '/package/confirm?id=' . $package->id . '&token=' . md5($package->id . env('APP_KEY')) . '">tại đây</a>';
                    $content = str_replace('_LINK_', $packageLink, $content);
                    $content = str_replace('_SHOP_', $package->name, $content);
                    $content = str_replace('_ACCOUNT_', $package->account, $content);
                    $content = str_replace('_PASSWORD_', $package->password, $content);
                    
                    $downloadLink = '<a href="' . url('/') . '/package/offline?code=' . $offlinePackage->code . '">tại đây</a>';
                    $content = str_replace('_DOWNLOAD_', $downloadLink, $content);
                    $content = str_replace('_ACTIVE_CODE_', $offlinePackage->code, $content);
                    
                    $msg->to($package->customer->email)
                        ->subject($template->title)
                        ->setBody($content, 'text/html');
                });
                return response()->json([
                    'success' => 1
                ], 200);
            }
            return response()->json([
                'success' => 1
            ], 200);
        }
    }

    public function offlineActivate()
    {
        $inputs = Request::all();
        
        if (empty($inputs['code'])) {
            echo 0;
            exit();
        }
        
        $offlinePackage = OfflinePackage::where('code', $inputs['code'])->where('expiry_date', '>=', date('Y-m-d H:i:s'))->first();
        if ($offlinePackage) {
            echo 1;
        } else {
            echo 0;
        }
        exit();
    }
}
