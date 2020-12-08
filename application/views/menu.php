<ul class="nav nav-list">
	<?php 
		if($this->session->userdata('role') == 1){
	?>
	<li class="active">
		<a href="<?php echo base_url('home/index');?>">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text"> Dashboard </span>
		</a>

		<b class="arrow"></b>
	</li>
	
	<li class="">
		<a href="<?php echo base_url('location/index')?>">
			<i class="menu-icon fa fa-map-marker"></i>
			<span class="menu-text"> Location</span>
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
		<a href="<?php echo base_url('customer/index')?>">
			<i class="menu-icon fa fa-user"></i>
			<span class="menu-text"> Customer</span>
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
		<a href="<?php echo base_url('history_item/index')?>">
			<i class="menu-icon fa fa-history"></i>
			<span class="menu-text"> History Item</span>
		</a>

		<b class="arrow"></b>
	</li>
	<li class="">
		<a href="<?php echo base_url('penjualan/index')?>">
			<i class="menu-icon fa fa-cart-plus"></i>
			<span class="menu-text"> Penjualan</span>
		</a>

		<b class="arrow"></b>
	</li>
	<li class="">
		<a href="<?php echo base_url('pengeluaran/index')?>">
			<i class="menu-icon fa fa-exchange"></i>
			<span class="menu-text"> Pengeluaran</span>
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
				<a href="<?php echo base_url('report_penjualan/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Penjualan
				</a>

				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo base_url('report_pengeluaran/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Pengeluaran
				</a>

				<b class="arrow"></b>
			</li>
		</ul>
	</li>
	<?php
		}else{
	?>
		<li class="active">
			<a href="<?php echo base_url('home/index');?>">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> Dashboard </span>
			</a>
			<b class="arrow"></b>
		</li>
		<li class="">
			<a href="<?php echo base_url('customer/index')?>">
				<i class="menu-icon fa fa-user"></i>
				<span class="menu-text"> Customer</span>
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
			<a href="<?php echo base_url('penjualan/index')?>">
				<i class="menu-icon fa fa-cart-plus"></i>
				<span class="menu-text"> Penjualan</span>
			</a>

			<b class="arrow"></b>
		</li>
		<li class="">
			<a href="<?php echo base_url('pengeluaran/index')?>">
				<i class="menu-icon fa fa-exchange"></i>
				<span class="menu-text"> Pengeluaran</span>
			</a>

			<b class="arrow"></b>
		</li>

		<?php 
			if($this->session->userdata('role') == 2) {
		?>
		<li class="">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-book"></i>
				<span class="menu-text"> Report </span>

				<b class="arrow fa fa-angle-down"></b>
			</a>

			<b class="arrow"></b>

			<ul class="submenu">
				<li class="">
					<a href="<?php echo base_url('report_penjualan/index');?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Penjualan
					</a>

					<b class="arrow"></b>
				</li>
				<li class="">
					<a href="<?php echo base_url('report_pengeluaran/index');?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Pengeluaran
					</a>

					<b class="arrow"></b>
				</li>
			</ul>
		</li>
		<?php
			}
		?>
	<?php
		}
	?>
</ul>