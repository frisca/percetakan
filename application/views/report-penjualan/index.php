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

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<div>
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
											foreach ($report as $key => $value) {
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
						</div>
					</div>
				</div><!-- /.page-content -->

				<div id="dp1_modal" class="modal">
				    <div class="modal-dialog">
				      <div class="modal-content">
				      
				        <!-- Modal Header -->
				        <div class="modal-header">
				          	<button type="button" class="close" data-dismiss="modal">&times;</button>
        					<h4 class="modal-title">Pembayaran Untuk DP</h4>
				        </div>
				        <form action="<?php echo base_url('penjualan/processDP1');?>" method="post">
					        <!-- Modal body -->
					        <div class="modal-body">
					            <div class="row">
					            	<input type="hidden" class="form-control" name="id_header_penjualan" value="" />
					            	<input type="hidden" id="grand_total" placeholder="Grand Total" class="form-control" name="grandtotal" required disabled />
									<div class="col-sm-12 form-group">
										<label>Grand Total</label>
										<input type="text" id="grand_total" placeholder="Grand Total" class="form-control" name="grandtotals" required disabled />
									</div>
									<div class="col-sm-12 form-group">
										<label>Pembayaran Untuk DP</label>
										<input type="text" placeholder="DP" id="dp1" class="form-control" name="dp1" required />
									</div>
					            </div>
					        </div>
					        <!-- Modal footer -->
					        <div class="modal-footer">
					        	<button type="submit" class="btn btn-primary submit_dp1">Simpan</button>
					            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
					        </div>
				        </form>
				      </div>
				    </div>
				</div>

				<div id="dp2_modal" class="modal">
				    <div class="modal-dialog">
				      	<div class="modal-content">
					        <!-- Modal Header -->
					        <div class="modal-header">
					          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        					<h4 class="modal-title">Pembayaran Untuk DP</h4>
					        </div>
					        <form action="<?php echo base_url('penjualan/processDP2');?>" method="post">
						        <!-- Modal body -->
						        <div class="modal-body">
						            <div class="row">
						            	<input type="hidden" class="form-control" name="id_header_penjualan" value="" />
										<div class="col-sm-12 form-group">
											<label>Grand Total</label>
											<input type="text" id="grand_total" placeholder="Grand Total" class="form-control" name="grandtotal" required disabled />
										</div>
										<div class="col-sm-12 form-group">
											<label>Pembayaran Untuk DP</label>
											<input type="text" placeholder="DP" id="dp1" class="form-control" name="dp1" required disabled />
										</div>
										<div class="col-sm-12 form-group">
											<label>Sisa Pembayaran</label>
											<input type="text" placeholder="DP" id="dp2" class="form-control" name="dp" required disabled />
										</div>
						            </div>
						        </div>
						        <!-- Modal footer -->
						        <div class="modal-footer">
						        	<button type="submit" class="btn btn-primary submit_dp1">Simpan</button>
						            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
						        </div>
					        </form>
				      	</div>
				    </div>
				</div>

				<!-- The Modal -->
				<div id="delete_modal" class="modal">
				    <div class="modal-dialog">
					    <div class="modal-content">
					        <!-- Modal Header -->
					        <div class="modal-header">
					          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        					<h4 class="modal-title">Delete Data Penjualan</h4>
					        </div>
					        <form action="<?php echo base_url('penjualan/delete')?>" method="post">
					        	<div class="modal-body">
					            	<div class="row">
					            		<input type="hidden" class="form-control" name="id" value="" />
										<div class="col-sm-12 form-group">
											<label>Keterangan</label>
											<input type="text" class="form-control" name="keterangan_delete" value="" required/>
										</div>
					            	</div>
					            </div>
					            <div class="modal-footer">
						        	<button type="submit" class="btn btn-primary">Hapus</button>
						            <button type="button" class="btn btn-danger" data-dismiss="modal" id="batalPenjualan">Batal</button>
						        </div>
					        </form>
					    </div>
				    </div>
				</div>
			</div>
		</div><!-- /.main-content -->

		<?php $this->load->view('footer');?>
	</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>