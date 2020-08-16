<?php $this->load->view("script_header");?>
<?php $this->load->view('header');?>
<div class="main-container ace-save-state" id="main-container">
	<script type="text/javascript">
		try{ace.settings.loadState('main-container')}catch(e){}
	</script>

	<div id="sidebar" class="sidebar responsive ace-save-state">
		<?php $this->load->view("menu");?>
		<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
			<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
		</div>
	</div>

	<div class="main-content">
		<div class="main-content-inner">
			<div class="breadcrumbs ace-save-state" id="breadcrumbs">
				<ul class="breadcrumb">
					<li>
						<i class="ace-icon fa fa-home home-icon"></i>
						<a href="#">Home</a>
					</li>
					<li class="active">Penjualan</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">
				<div class="page-header">
					<h1>
						Penjualan
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Penjualan
						</small>
					</h1>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<?php if(validation_errors() != ""){?>
							<div class="alert alert-danger form-group">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo validation_errors();?>
							</div>
						<?php } ?>

						<?php if($this->session->flashdata('error') != ""){?>
							<div class="alert alert-danger form-group">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $this->session->flashdata('error');?>
							</div>
						<?php } ?>
					</div>
						
					<div class="col-xs-12">
						<div class="table-header">
							Data Penjualan
						</div>
					</div>

					<!-- <div class="col-xs-12"> -->
						<!-- PAGE CONTENT BEGINS -->
						
				<form style="margin-top:50px;" method="post" action="<?php echo base_url('penjualan/checkout/' . $header_penjualan->id_header_penjualan);?>">
					<div class="col-sm-6 form-group">
						<label>Nomor Penjualan</label>
						<?php
							if((int)$header_penjualan->metode_pembayaran == 2 || (int)$header_penjualan->metode_pembayaran == 1){
						?>
							<input type="text" placeholder="Nomor Penjualan" class="form-control" name="id_head" value="<?php echo $header_penjualan->nomor_penjualan;?>" disabled/>
						<?php
							}else{
						?>
							<input type="text" placeholder="Nomor Penjualan" class="form-control" name="id_head" value="<?php echo $header_penjualan->id_header_penjualan;?>" disabled/>
						<?php
							}
						?>
					</div>
					<div class="col-sm-6 form-group">
						<label>Tanggal Penjualan</label>
						<input type="text" placeholder="Tanggal Penjualan" class="form-control" name="tgl_penjualan" value="<?php echo date('d-m-Y', strtotime($header_penjualan->tgl_penjualan));?>" id="tgl_transaksi">
					</div>
					<div class="col-sm-6 form-group">
						<label>Dibuat Oleh</label>
						<input type="text" placeholder="Dibuat Oleh" class="form-control" name="updatedBy" value="<?php echo $user->nama;?>" disabled/>
					</div>
					<div class="col-sm-6 form-group">
						<label>Dibuat Tanggal</label>
						<input type="text" placeholder="Dibuat Tanggal" class="form-control" name="updatedDates" value="<?php
						date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s');?>" disabled/>
					</div>
					<input type="hidden"  class="form-control" name="updatedDate" value="<?php
					date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s');?>"/>
					<div class="col-sm-6 form-group">
						<label>Total</label>
						<input type="text" placeholder="Total" class="form-control" name="totals" value="<?php echo number_format($header_penjualan->total,0,'','.');?>" disabled>
						<input type="hidden"  name="total" value="<?php echo $header_penjualan->total;?>">
					</div>
					<div class="col-sm-6 form-group">
						<label>Discount</label>
						<input type="text" placeholder="Discount" class="form-control discount" name="discounts" value="<?php echo number_format($header_penjualan->discount, 0, '', '.');?>" disabled>
					</div>
					<div class="col-sm-6 form-group">
						<label>Grand Total</label>
						<input type="text" placeholder="Total" class="form-control" name="grandtotals" value="<?php echo number_format($header_penjualan->grandtotal,0,'','.');?>" disabled>
						<input type="hidden" name="grandtotal" value="<?php echo $header_penjualan->grandtotal;?>">
					</div>
					<div class="col-sm-6 form-group">
						<label>Metode Pembayaran</label>
						<select name="metode_pembayaran" class="metode_pembayaran" data-placeholder="Click to Choose..." class="form-control metode_pembayaran" style="width: 100%" required disabled>
							<?php
								if($header_penjualan->metode_pembayaran == 2){
							?>
								<option value="0">Pilih Metode Pembayaran</option>
								<option value="1">Lunas</option>
								<option value="2" selected>DP</option>
							<?php
								}else if($header_penjualan->metode_pembayaran == 1){
							?>
								<option value="0">Pilih Metode Pembayaran</option>
								<option value="1" selected>Lunas</option>
								<option value="2">DP</option>
							<?php
								}else{
							?>
								<option value="0" selected>Pilih Metode Pembayaran</option>
								<option value="1">Lunas</option>
								<option value="2">DP</option>
							<?php
								}
							?>
						</select>
					</div>
					<div class="col-sm-6 form-group" style="margin-left: 1px;">
						<label>Customer</label>
						<select name="id_customer" class="select2 customers" data-placeholder="Click to Choose..."  style="width: 100%" disabled>
						<?php
							foreach($customer as $key=>$value){
								if($value->id_customer == $header_penjualan->id_customer){
						?>
								<option value="<?php echo $value->id_customer;?>" selected><?php echo $value->first_name . ' ' . $value->last_name ;?></option>
						<?php
								}else{
						?>
								<option value="<?php echo $value->id_customer;?>"><?php echo $value->first_name . ' ' . $value->last_name ;?></option>
						<?php
								}
							}
						?>
						</select>
					</div>
					<!-- </div> -->
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="table-header">
							Item
						</div>

						<!-- div.dataTables_borderWrap -->
						<div>
							<table id="example" class="table table-striped table-bordered table-hover" style="width:100%;">
								<thead>
									<tr>
										<th>Nama Item</th>
										<th>Satuan</th>
										<th>Line Item</th>
										<th>Keterangan</th>
										<th>Jumlah</th>
										<th>Harga Satuan</th>
										<th>Total Harga</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($penjualan as $key => $value) {
									?>
										<tr>
											<td><?php echo $value->nama;?></td>
											<td><?php echo $value->satuan;?></td>
											<td>
												<?php
													if($value->line_item == ""){
												?>
												<a href="<?php echo base_url('gambar/' . $value->line_item);?>" target="_blank">
													<img id="my_image" src="<?php echo base_url('gambar/no_img.png');?>" style="width: 100px;height: 100px;margin-bottom: 10px;"/>
												</a>
												<?php 
													}else{
												?>
												<a href="<?php echo base_url('gambar/' . $value->line_item);?>" target="_blank">
													<img id="my_image" src="<?php echo base_url('gambar/' . $value->line_item);?>" style="width: 100px;height: 100px;margin-bottom: 10px;"/>
												</a>
												<?php
													}
												?>
											</td>
											<td><?php echo $value->keterangan;?></td>
											<td><?php echo $value->qty;?></td>
											<td><?php echo number_format($value->harga_satuan,0,'','.');?></td>
											<td><?php echo number_format($value->total_harga,0,'','.');?></td>
										</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-xs-12">
						<a href="<?php echo base_url('penjualan/index');?>">
							<button class="btn" type="button" style="margin-top: 10px;">
								Back
							</button>
						</a>
					</div>
				</form>
				</div><!-- /.row -->
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>