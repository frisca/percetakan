<ul class="nav nav-list">
	<li class="active">
		<a href="index.html">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text"> Dashboard </span>
		</a>

		<b class="arrow"></b>
	</li>
	<li class="">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-users"></i>
			<span class="menu-text"> Users </span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li class="">
				<a href="<?php echo base_url('admin/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Admin
				</a>

				<b class="arrow"></b>
			</li>

			<li class="">
				<a href="<?php echo base_url('operator/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Operator
				</a>

				<b class="arrow"></b>
			</li>

			<li class="">
				<a href="<?php echo base_url('administrator/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Administrator
				</a>

				<b class="arrow"></b>
			</li>
		</ul>
	</li>
	<li class="">
		<a href="<?php echo base_url('satuan/index')?>">
			<i class="menu-icon fa fa-cog"></i>
			<span class="menu-text"> Satuan</span>
		</a>

		<b class="arrow"></b>
	</li>
	<li class="">
		<a href="<?php echo base_url('item/index')?>">
			<i class="menu-icon fa fa-list"></i>
			<span class="menu-text"> Item</span>
		</a>

		<b class="arrow"></b>
	</li>
	<li class="">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-book"></i>
			<span class="menu-text"> Report </span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li class="">
				<a href="<?php echo base_url('admin/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					In
				</a>

				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo base_url('operator/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Out
				</a>

				<b class="arrow"></b>
			</li>
		</ul>
	</li>
</ul><!-- /.nav-list -->