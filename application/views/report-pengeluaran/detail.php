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
					<li class="active">Lihat Report Pengeluaran</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">
				<div class="page-header">
					<h1>
						Lihat Report Pengeluaran
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Lihat Report Pengeluaran
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
							Lihat Data Report Pengeluaran
						</div>
					</div>

					<div class="col-xs-12">
						<div>
							<table id="example" class="table table-striped table-bordered table-hover" style="width:100%;">
								<thead>
									<tr>
										<th>No</th>
										<th>Nomor Pengeluaran</th>
										<th>Tgl Pengeluaran</th>
										<th>Total</th>
										<th>Status Pengeluaran</th>
										<th>Tgl Dibuat</th>
										<th>Dibuat Oleh</th>
										<th>Tgl Diubah</th>
										<th>Diubah Oleh</th>
										<th>Item</th>
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
										foreach ($report as $list) {
											// $created_by = $this->all_model->getDataByCondition("customer", array("id_customer" => $list->createdBy))->row();
											// $updated_by = $this->all_model->getDataByCondition("customer", array("id_customer" => $list->updatedBy))->row();
											$total = $total + $list->total;
								
											if($list->status == 1){
												$stat = 'Close';
											}else{
												$stat = 'Open';
											}
								
											$list->tgl_pengeluaran = explode(" ", $list->tgl_pengeluaran);
											$list->updated_date = explode(" ", $list->updated_date);
											$list->created_date = explode(" ", $list->created_date);
								
											if($list->tgl_pengeluaran[0] == '1970-01-01' || $list->tgl_pengeluaran[0] == '0000-00-00'){
												$tgl_pengeluaran = '';
											}else{
												$tgl_pengeluaran = date('d-m-Y', strtotime($list->tgl_pengeluaran[0]));
											}
								
											if($list->updated_date[0] == '1970-01-01' || $list->updated_date[0] == '0000-00-00'){
												$updatedDate = '';
											}else{
												$updatedDate = date('d-m-Y', strtotime($list->updated_date[0]));
											}
								
											if($list->created_date[0] == '1970-01-01' || $list->created_date[0] == '0000-00-00'){
												$createdDate = '';
											}else{
												$createdDate = date('d-m-Y', strtotime($list->created_date[0]));
											}
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo $list->id_header_pengeluaran;?></td>
										<td><?php echo $tgl_pengeluaran;?></td>
										<td><?php echo 'Rp ' . number_format($list->total, 0, '', '.');?></td>
										<td><?php echo $stat;?></td>
										<td><?php echo $createdDate;?></td>
										<td>
											<?php
												if(!empty($user)){
													foreach ($user as $keys => $values) {
														if($values->id_user == $list->created_by){
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
														if($values->id_user == $list->updated_by){
															echo $values->nama;
														}
													}
												}
											?>
										</td>
										<td><?php echo $list->item;?></td>
										<td><?php echo 'Rp ' . number_format($list->total_harga, 0, '', '.')?></td>
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
					<div class="col-xs-12">
						<a href="<?php echo base_url('report_pengeluaran/index');?>">
							<button class="btn" type="button" style="margin-top: 10px;">
								Back
							</button>
						</a>
					</div>
				</div><!-- /.row -->
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>