<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Category;
use App\Models\EmailType;
use App\Models\Package;
use App\Models\Customer;
use App\Models\EmailTemplate;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$this->call('UserTableSeeder');
		// $this->call('CategoryTableSeeder');
		//$this->call('EmailTypeTableSeeder');
		//$this->call('EmailTemplateTableSeeder');
		
		//$this->call('PackageTableSeeder');
	}

}

class UserTableSeeder extends Seeder {
	public function run()
	{
		DB::table('users')->delete();
		User::create([
			'name' => 'admin',
			'email' => 'admin4biz@gmail.com',
			'password' => bcrypt('12346789#')
		]);
	}
}

class CategoryTableSeeder extends Seeder {
	public function run()
	{
		$categories = [
			['name' => 'Bất động sản', 'code' => 'bds', 'type' => 'biz'],
			['name' => 'Tài chính-kế toán', 'code' => 'tckt', 'type' => 'biz'], 
			['name' => 'Thủ công mỹ nghệ', 'code' => 'tcmn', 'type' => 'biz'],
			['name' => 'Thời trang -Trang sức', 'code' => 'ttts', 'type' => 'biz'],
			['name' => 'Dịch vụ - Du lịch khách sạn', 'code' => 'dvdlks', 'type' => 'biz'],
			['name' => 'Giáo dục - đào tạo', 'code' => 'gddt', 'type' => 'biz'],
			['name' => 'Nhà hàng - sự kiện', 'code' => 'nhsk', 'type' => 'biz'],
			['name' => 'Ôtô - xe máy', 'code' => 'otoxm', 'type' => 'biz'],
			['name' => 'Máy tính - công nghệ', 'code' => 'mtcn', 'type' => 'biz'],
			['name' => 'Điện thoại - điện máy', 'code' => 'dtdm', 'type' => 'biz'],
			['name' => 'Spa - làm đẹp', 'code' => 'spald', 'type' => 'biz'],
			['name' => 'Nhà thuốc', 'code' => 'nt', 'type' => 'biz'],
			['name' => 'Nội thất gia dụng', 'code' => 'ntgd', 'type' => 'biz'],
			['name' => 'Vật liệu xây dựng', 'code' => 'vlxd', 'type' => 'biz'],
			['name' => 'Vật nuôi- thú cưng', 'code' => 'vntc', 'type' => 'biz'],
			['name' => 'Nghành khác', 'code' => 'nk', 'type' => 'biz'],
			['name' => 'Máy tính- công nghệ kỹ thuật số', 'code' => 'mtcnkts', 'type' => 'pos'],
			['name' => 'Điện thoại-điện máy', 'code' => 'dtdm', 'type' => 'pos'],
			['name' => 'Sản phẩm trẻ em', 'code' => 'spte', 'type' => 'pos'],
			['name' => 'Mỹ phẩm - dược phẩm - nước hoa', 'code' => 'mpdpnh', 'type' => 'pos'],
			['name' => 'Nhà thuốc, Bar - caffe - nhà hàng', 'code' => 'ntbarnh', 'type' => 'pos'],
			['name' => 'Thực phẩm - đồ uống', 'code' => 'tpdu', 'type' => 'pos'],
			['name' => 'Sách - văn phòng phẩm', 'code' => 'svpp', 'type' => 'pos'],
			['name' => 'Hoa - quà tặng', 'code' => 'hqt', 'type' => 'pos'],
			['name' => 'Nội thất - gia dụng', 'code' => 'ntgd', 'type' => 'pos'],
			['name' => 'Vật liệu xây dựng', 'code' => 'vlxd', 'type' => 'pos'],
			['name' => 'Dụng cụ thể thao', 'code' => 'dctt', 'type' => 'pos'],
			['name' => 'Vật nuôi - thú cưng', 'code' => 'vntc', 'type' => 'pos'],
			['name' => 'Tạp hóa', 'code' => 'th', 'type' => 'pos'],
			['name' => 'Siêu thị mini', 'code' => 'stmini', 'type' => 'pos'],
			['name' => 'Thời trang - trang sức', 'code' => 'ttts', 'type' => 'pos'],
			['name' => 'Nghành khác', 'code' => 'nk', 'type' => 'pos'],
		];
		
		DB::table('categories')->delete();
		foreach ($categories as $category)
		{
			Category::create($category);
		}
	}
}

class EmailTypeTableSeeder extends Seeder {
	public function run()
	{
		$types = [
			['name' => 'Email xác nhận đăng ký', 'code' => 'email_confirm'],
			['name' => 'Email cảnh bảo hết hạn', 'code' => 'email_warning'],
			['name' => 'Email gia hạn dịch vụ', 'code' => 'email_extend_exp_time'],
			['name' => 'Email đăng ký dịch vụ offline', 'code' => 'email_generate_offline_code']
		];

		DB::table('email_types')->delete();
		foreach ($types as $type)
		{
			EmailType::create($type);
		}
	}
}

class EmailTemplateTableSeeder extends Seeder {
	public function run()
	{
		$emailConfirmcontent = <<<EOD
<p>Hello,</p>
<p>&nbsp;</p>
<p>Ch&uacute;c mừng bạn đ&atilde; đăng k&yacute; th&agrave;nh c&ocirc;ng dịch vụ 4BIZ, để sử dụng dịch vụ bạn vui l&ograve;ng click v&agrave;o link sau để k&iacute;ch hoạt dịch vụ _LINK_</p>
<p>&nbsp;</p>
<p>Th&ocirc;ng tin:</p>
<p>T&ecirc;n shop: _SHOP_</p>
<p>T&ecirc;n đăng nhập: _ACCOUNT_</p>
<p>Mật khẩu: _PASSWORD_</p>
<p>&nbsp;</p>
<p>Cảm ơn v&igrave; đ&atilde; sử dụng dịch vụ của ch&uacute;ng t&ocirc;i,</p>
EOD;

		DB::table('email_templates')->delete();
		$type = EmailType::where('code', 'email_confirm')->first();
		
		EmailTemplate::create([
			'type_id' => $type->id,
			'title' => 'Đăng ký sử dụng dịch vụ 4Biz',
			'content' => $emailConfirmcontent
		]);
		
		$emailWanringContent = <<<EOD
<p>Hello,</p>
<p>&nbsp;</p>
<p>G&oacute;i dịch vụ d&ugrave;ng thử của bạn c&ograve;n _DAYS_ ng&agrave;y (_MINUTES_ ph&uacute;t) d&ugrave;ng thử nữa.</p>
<p>Th&ocirc;ng tin g&oacute;i dịch vụ của bạn như sau:</p>
<p>T&ecirc;n shop: _SHOP_</p>
<p>T&ecirc;n đăng nhập: _ACCOUNT_</p>
<p>Mật khẩu: _PASSWORD_</p>
<p>&nbsp;</p>
<p>Cảm ơn bạn đ&atilde; sử dụng dịch vụ của ch&uacute;ng t&ocirc;i.</p>
EOD;
		$type = EmailType::where('code', 'email_warning')->first();
		
		EmailTemplate::create([
				'type_id' => $type->id,
				'title' => 'Gia hạn dịch vụ 4BIZ?',
				'content' => $emailWanringContent
		]);
		
		
		$emailWanringContent = <<<EOD
<p>Hello _CUSTOMER_</p>
<p>&nbsp;</p>
<p>Ch&uacute;c mừng bạn đ&atilde; gia hạn th&agrave;nh c&ocirc;ng dịch vụ 4BIZ</p>
<p>&nbsp;</p>
<p>T&ecirc;n shop: _SHOP_</p>
<p>Thời gian hết hạn: _EXPIRY_TIME_</p>
<p>&nbsp;</p>
<p>Cảm ơn đ&atilde; sử dụng dịch vụ của ch&uacute;ng t&ocirc;i!</p>
EOD;
		$type = EmailType::where('code', 'email_extend_exp_time')->first();
		
		EmailTemplate::create([
				'type_id' => $type->id,
				'title' => 'Gia hạn dịch vụ thành công!',
				'content' => $emailWanringContent
		]);
		
		
		$emailGenerateOfflineCode = <<<EOD
<p>Hi,</p>
<p>Bạn vừa đăng k&yacute; dịch vụ 4biz offline.</p>
<p>&nbsp;</p>
<p>Download: _DOWNLOAD_</p>
<p>Active code: _ACTIVE_CODE_</p>
<p>&nbsp;</p>
<p>Thanks,</p>
EOD;
		$type = EmailType::where('code', 'email_generate_offline_code')->first();
		
		EmailTemplate::create([
				'type_id' => $type->id,
				'title' => 'Đăng ký dịch vụ 4BIZ offline',
				'content' => $emailGenerateOfflineCode
		]);
	}
}



class PackageTableSeeder extends Seeder {
	public function run()
	{
		$categories = [
			'Thời trang',
			'Mẹ & Bé', 
			'Mỹ phẩm', 
			'Siêu thị mini', 
			'Điện máy',
			'Vật liệu xây dựng'
		];
		$cities = ['Hà Nội', 'Hải Phòng', 'Đà Nẵng'];
		
		$domains = ['thienlong.4biz.vn', 'thienminh.4biz.vn', 'thoitrangnam.4biz.vn'];
		
		DB::table('packages')->delete();
		DB::table('customers')->delete();
		foreach ($domains as $index => $domain) {
			
			$city = $cities[array_rand($cities)];
			
			$category = Category::where('name', $categories[array_rand($categories)])->first();
			$customer = new Customer();
			
			$customer->name = 'Package ' . $index;
			$customer->email = 'package' . $index . '@gmail.com';
			$customer->address = 'Address ' . $index;
			$customer->city = $city;
			$customer->save();
			
			Package::create([
				'customer_id' => $customer->id,
				'category_id' => $category->id,
				'name' => 'Package ' . $index,
				'domain' => $domain,
				'account' => 'admin',
				'password' => '12345678',
				'expiry_time' => date('Y-m-d H:m:s', strtotime("+". rand(1, 14) ." days"))
			]);
		}
	}
}
