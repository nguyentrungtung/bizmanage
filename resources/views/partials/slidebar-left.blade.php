<div class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li>
				<a href="#"><i class="fa fa-dashboard fa-fw"></i> Thống kê & Báo cáo</a>
			</li>
			<li>
				<a href="{{ url('/customer') }}"><i class="fa fa-users fa-fw"></i> Khách hàng</a>
			</li>
			
			<li class="active">
				<a href="#"><i class="fa fa-cubes fa-fw"></i> Gói dịch vụ <span class="fa arrow"></a>
				<ul class="nav nav-second-level collapse in">
					<li><a href="{{ url('/package/list/online') }}"><i class="fa fa-cloud fa-fw"></i> Online</a></li>
					<li><a href="{{ url('/package/list/internal') }}"><i class="fa fa-group fa-fw"></i> Nội bộ</a></li>
				</ul>
			</li>
			<li>
				<a href="{{ url('/email') }}"><i class="fa fa-envelope fa-fw"></i> Mẫu Email</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-print fa-fw"></i> Mẫu báo cáo</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-user fa-fw"></i> Nhân viên</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-support fa-fw"></i> Chăm sóc khách hàng</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-cube fa-fw"></i> Cấu hình gói dịch vụ</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-cog fa-fw"></i> Cấu hình hệ thống</a>
			</li>
		</ul>
		<!-- /#side-menu -->
	</div>
	<!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
