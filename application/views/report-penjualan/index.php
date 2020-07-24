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
						<li>Report</li>
						<li class="active">Penjualan</li>
					</ul><!-- /.breadcrumb -->

					<div class="nav-search" id="nav-search">
						<form class="form-search">
							<span class="input-icon">
								<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
								<i class="ace-icon fa fa-search nav-search-icon"></i>
							</span>
						</form>
					</div><!-- /.nav-search -->
				</div>
				<div class="page-content">
					<div class="page-header">
						<h1>
							Report Penjualan
							<small>
								<i class="ace-icon fa fa-angle-double-right"></i>
								Report Penjualan
							</small>
						</h1>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<div class="table-header">
								Report Penjualan
							</div>
						</div>
							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
						<form method="post" action="<?php echo base_url('report_penjualan/search');?>">
							<div class="col-xs-2" style="margin-top:10px;margin-bottom:10px;">
								<input type="text" placeholder="Dari Tanggal" class="form-control" name="from_date" value="<?php if(!empty($from)){ echo date('d-m-Y', strtotime($from));}?>" id="from_date"/>
							</div>

							<div class="col-xs-2" style="margin-top:10px;margin-bottom:10px;">
								<input type="text" placeholder="Sampai Tanggal" class="form-control" name="to_date" value="<?php if(!empty($to)){ echo date('d-m-Y', strtotime($to));}?>" id="to_date"/>
							</div>

							<div class="col-xs-2" style="margin-top:10px;margin-bottom:10px;">
								<input type="text" placeholder="No. Invoice" class="form-control" name="no_invoice" value="<?php if(!empty($no_invoice)){ echo $no_invoice;}?>" id="no_invoice"/>
							</div>

							<div class="col-xs-2" style="margin-top:10px;margin-bottom:10px;">
								<!-- <input type="text" placeholder="Customer" class="form-control customer" name="customer" value="<?php if(!empty($customer)){ echo $customer;}?>" id="customer"/> -->
								<input type="text" placeholder="Customer" class="form-control customer" name="customers" value="<? if(!empty($customer)){ echo $customer->first_name . ' ' . $customer->last_name;}?>">
								<input type="hidden" class="form-control customers" name="customer" value="<? if(!empty($customer)){ echo $customer->id_customer;}?>" id="customer">
							</div>

							<div class="col-xs-2" style="margin-top:10px;margin-bottom:10px;">
								<!-- <input type="text" placeholder="Status Invoice" class="form-control" name="status_invoice" value=""/> -->
								<select name="invoice" class="form-control" data-placeholder="Pilih status invoice ..." id="status" style="width: 100%">
									<?php if($status_invoice == "0"){?>
										<option value="-99">Pilih Status Invoice</option>
										<option value="0" selected>Belum checkout</option>
										<option value="1">Sudah checkout</option>
									<?php }else if($status_invoice == "1"){?>
										<option value="-99">Pilih Status Invoice</option>
										<option value="0">Belum checkout</option>
										<option value="1" selected>Sudah checkout</option>
									<?php }else{?>
										<option value="-99">Pilih Status Invoice</option>
										<option value="0">Belum checkout</option>
										<option value="1">Sudah checkout</option>
									<?php } ?>
								</select>
							</div>

							<div class="col-xs-2" style="margin-top:10px;margin-bottom:10px;">
								<!-- <input type="text" placeholder="Status Pembayaran" class="form-control" name="status_pembayaran" value=""/> -->
								<select name="status_pembayaran" class="form-control" data-placeholder="Pilih status pembayaran ..." id="status_pembayaran" style="width: 100%">
									<!-- <option value="-99">Pilih Status Pembayaran</option>
									<option value="1">Lunas</option>
									<option value="2">DP</option> -->
									<?php if($status_pembayaran == "1"){?>
										<option value="-99">Pilih Status Pembayaran</option>
										<option value="1" selected>Lunas</option>
										<option value="2">DP</option>
									<?php }else if($status_invoice == "2"){?>
										<option value="-99">Pilih Status Pembayaran</option>
										<option value="1">Lunas</option>
										<option value="2" selected>DP</option>
									<?php }else{?>
										<option value="-99">Pilih Status Pembayaran</option>
										<option value="1">Lunas</option>
										<option value="2">DP</option>
									<?php } ?>
								</select>
							</div>

							<div class="col-xs-2" style="margin-top:10px;margin-bottom:10px;">
								<button type="submit" class="search btn btn-sm btn-success" style="margin-bottom: 10px;">
								Cari
								</button>
								<button type="button" class="csv_penjualan btn btn-sm btn-info" style="margin-bottom: 10px;">
								Print
								</button>
							</div>
						</form>

						<div class="col-xs-12">
							<table id="example" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Nomor Invoice</th>
										<th>Tanggal Invoice</th>
										<th>Nama Customer</th>
										<th>Total</th>
										<th>Discount</th>
										<th>GrandTotal</th>
										<th>DP 1</th>
										<th>DP 2</th>
										<th>Status Pembayaran</th>
										<th>Status Invoice</th>
										<th>Tanggal Dibuat</th>
										<th>Dibuat Oleh</th>
										<th>Tanggal Diubah</th>
										<th>Diubah Oleh</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$total = 0;
										$grandtotal = 0;
										$discount = 0;
										$dp1 = 0;
										$dp2 = 0;

										foreach ($report as $key => $value) {
											$total = $total + $value->total;
											$grandtotal = $grandtotal + $value->grandtotal;
											$discount = $discount + $value->discount;
											$dp1 = $dp1 + $value->dp1;
											$dp2 = $dp2 + $value->dp2;
									?>
									<tr>
										<td>
											<?php 
												if($value->status_pembayaran != 0){
													echo $value->nomor_penjualan;
												}else{
													echo $value->id_header_penjualan;
												}
											?>	
										</td>
										<td><?php echo date('d-m-Y', strtotime($value->tgl_penjualan));?></td>
										<td><?php echo $value->first_name . ' ' . $value->last_name;?></td>
										<td><?php echo number_format($value->total, 0, '', '.');?></td>
										<td><?php echo number_format($value->discount, 0, '', '.');?></td>
										<td><?php echo number_format($value->grandtotal, 0, '', '.');?></td>
										<td>
											<?php 
												if($value->dp1 != ""){
													echo $value->dp1;
												}
											?>
										</td>
										<td>
											<?php 
												if($value->dp2 != ""){
													echo $value->dp2;
												}
											?>
										</td>
										<td>
											<?php 
												if($value->metode_pembayaran == 2){
													echo 'DP';
												}else{
													echo 'Lunas';
												}
											?>
										</td>
										<td>
											<?php 
												if($value->status == 1){
													echo 'Sudah checkout';
												}else{
													echo 'Belum checkout';
												}
											?>
										</td>
										<td><?php echo date('d-m-Y', strtotime($value->createdDate));?></td>
										<td>
											<?php
												if(!empty($user)){
													foreach ($user as $keys => $values) {
														if($values->id_user == $value->createdBy){
															echo $values->nama;
														}
													}
												}
											?>
										</td>
										<td><?php echo date('d-m-Y', strtotime($value->updatedDate));?></td>
										<td>
											<?php
												if(!empty($user)){
													foreach ($user as $keys => $values) {
														if($values->id_user == $value->updatedBy){
															echo $values->nama;
														}
													}
												}
											?>
										</td>
										<td>
											<div class="hidden-sm hidden-xs action-buttons">
												<a class="blue" href="<?php echo base_url('report_penjualan/view/' . $value->id_header_penjualan);?>">
													<i class="ace-icon fa fa-search-plus bigger-130"></i>
												</a>
											</div>
										</td>
									</tr>
									<?php 
										}
									?>
								</tbody>
							</table>
						</div>

						<div class="col-xs-12" style="margin-top:20px;">
							<table id="example" class="table table-striped table-bordered table-hover">
								<tbody>
									<tr style="width:10%;">
										<th>Sum Total</th>
										<td><?php echo $total;?></td>
									</tr>
									<tr style="width:10%;">
										<th>Sum Total Discount</th>
										<td><?php echo $discount;?></td>
									</tr>
									<tr style="width:10%;">
										<th>Sum GrandTotal</th>
										<td><?php echo $grandtotal;?></td>
									</tr>
									<tr style="width:10%;">
										<th>Sum DP 1</th>
										<td><?php echo $dp1;?></td>
									</tr>
									<tr style="width:10%;">
										<th>Sum DP 2</th>
										<td><?php echo $dp2;?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->

		<?php $this->load->view('footer');?>
	</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>