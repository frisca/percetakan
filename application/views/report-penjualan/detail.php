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
					<li class="active">Lihat Report Penjualan</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">
				<div class="page-header">
					<h1>
						Lihat Report Penjualan
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Lihat Report Penjualan
						</small>
					</h1>
				</div>

				<div class="row">
					<div class="col-xs-12" style="margin-bottom:10px;">
						<a href="<?php echo base_url('report_penjualan/index');?>">
							<button class="btn" type="button">
								<i class="ace-icon fa fa-undo"></i>
								Kembali
							</button>
						</a>
					</div>

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
							Lihat Data Report Penjualan
						</div>
					</div>
					
					<div class="col-xs-12">
						<div>
							<table id="example" class="table table-striped table-bordered table-hover" style="width:100%;">
								<thead>
									<tr>
										<th width="50%">No</th>
										<th>Nomor Invoice</th>
										<th>Tgl Invoice</th>
										<th>Nama Customer</th>
										<th>Total</th>
										<th>Discount</th>
										<th>GrandTotal</th>
										<th>DP 1</th>
										<th>DP 2</th>
										<th>Status Pembayaran</th>
										<th>Status Invoice</th>
										<th>Tgl Dibuat</th>
										<th>Dibuat Oleh</th>
										<th>Tgl Diubah</th>
										<th>Diubah Oleh</th>
										<th>Item</th>
										<th>Unit</th>
										<th>Jumlah</th>
										<th>Harga Satuan</th>
										<th>Total Harga</th>
										<th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no = 1;
										$total = 0;
										$discount = 0;
										$grandtotal = 0;
										$dp1 = 0;
										$dp2 = 0;
										foreach($report as $key=>$list){
											$total = $total + $list->total;
											$discount = $discount + $list->discount;
											$grandtotal = $grandtotal + $list->grandtotal;
											$dp1 = $dp1 + $list->dp1;
											$dp2 = $dp2 + $list->dp2;

											if($list->status_pembayaran != 0){
												$nomor_invoice = $list->nomor_penjualan;
											}else{
												$nomor_invoice = $list->id_header_penjualan;
											}

											if((int)$list->status_pembayaran == 2){
												$stat_payment = 'DP';
											}else if((int)$list->status_pembayaran == 1){
												$stat_payment = 'Lunas';
											}else{
												$stat_payment = 'Belum Bayar';
											}

											if((int)$list->status_invoice == 0){
												$stat_invoice =  'Belum Checkout';
											}else if((int)$list->status_invoice == 1){
												$stat_invoice =  'Sudah Checkout';
											}else{
												$stat_invoice =  "Belum Checkout";
											}

											$list->tgl_penjualan = explode(" ", $list->tgl_penjualan);
											$list->updatedDate = explode(" ", $list->updatedDate);
											$list->createdDate = explode(" ", $list->createdDate);

											if($list->tgl_penjualan[0] == '1970-01-01' || $list->tgl_penjualan[0] == '0000-00-00'){
												$tgl_penjualan = '';
											}else{
												$tgl_penjualan = date('d-m-Y', strtotime($list->tgl_penjualan[0]));
											}

											if($list->updatedDate[0] == '1970-01-01' || $list->updatedDate[0] == '0000-00-00'){
												$updatedDate = '';
											}else{
												$updatedDate = date('d-m-Y', strtotime($list->updatedDate[0]));
											}

											if($list->createdDate[0] == '1970-01-01' || $list->createdDate[0] == '0000-00-00'){
												$createdDate = '';
											}else{
												$createdDate = date('d-m-Y', strtotime($list->createdDate[0]));
											}
									?>
									<tr>
										<td><?php echo $no;?></td>	
										<td><?php echo $nomor_invoice;?></td>
										<td><?php echo $tgl_penjualan;?></td>
										<td><?php echo $list->first_name . ' ' . $list->last_name;?></td>
										<td><?php echo 'Rp ' . number_format($list->total, 0, '', '.');?></td>
										<td><?php echo 'Rp ' . number_format($list->discount, 0, '', '.');?></td>
										<td><?php echo 'Rp ' . number_format($list->grandtotal, 0, '', '.');?></td>
										<td><?php echo 'Rp ' . number_format($list->dp1, 0, '', '.');?></td>
										<td><?php echo 'Rp ' . number_format($list->dp2, 0, '', '.');?></td>
										<td><?php echo $stat_payment;?></td>
										<td><?php echo $stat_invoice;?></td>
										<td><?php echo $createdDate;?></td>
										<td>
											<?php
												if(!empty($user)){
													foreach ($user as $keys => $values) {
														if($values->id_user == $list->createdBy){
															echo $values->nama;
														}
													}
												}
											?>
										</td>
										<td><?php echo $updatedDate;?></td>
										<td>
											<?php
												if(!empty($user)){
													foreach ($user as $keys => $values) {
														if($values->id_user == $list->updatedBy){
															echo $values->nama;
														}
													}
												}
											?>
										</td>
										<td><?php echo $list->item;?></td>
										<td><?php echo $list->unit;?></td>
										<td><?php echo $list->qty_item;?></td>
										<td><?php echo 'Rp ' . number_format($list->harga_satuan, 0, '', '.');?></td>
										<td><?php echo 'Rp ' . number_format($list->total_harga, 0, '', '.');?></td>
										<td><?php echo $list->keterangan;?></td>
									</tr>
									<?php
											$no++;
										}
									?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-xs-12" style="margin-top:20px;">
						<table id="example" class="table table-striped table-bordered table-hover" style="width:100%;">
							<tbody>
								<tr style="width:10%;">
									<th>Sum Total</th>
									<td><?php echo number_format($total, 0, '', '.');?></td>
								</tr>
								<tr style="width:10%;">
									<th>Sum Total Discount</th>
									<td><?php echo number_format($discount, 0, '', '.');?></td>
								</tr>
								<tr style="width:10%;">
									<th>Sum GrandTotal</th>
									<td><?php echo number_format($grandtotal, 0, '', '.');?></td>
								</tr>
								<tr style="width:10%;">
									<th>Sum DP 1</th>
									<td><?php echo number_format($dp1, 0, '', '.');?></td>
								</tr>
								<tr style="width:10%;">
									<th>Sum DP 2</th>
									<td><?php echo number_format($dp2, 0, '', '.');?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-xs-12">
						<a href="<?php echo base_url('report_penjualan/index');?>">
							<button class="btn" type="button" style="margin-top: 10px;">
								Kembali
							</button>
						</a>
					</div>
				</div>
					<!-- <div class="col-xs-12"> -->
						<!-- PAGE CONTENT BEGINS -->
				</div><!-- /.row -->
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>