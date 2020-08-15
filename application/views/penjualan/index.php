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
							<div class="clearfix">
								<div class="pull-right tableTools-container">
									<div class="dt-buttons btn-overlap btn-group">
										<a class="dt-button buttons-collection buttons-colvis btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table" href="<?php echo base_url('penjualan/add');?>">
											<span><i class="fa fa-plus bigger-110 blue"></i> 
												<span class="hidden">Add Data Penjualan</span>
											</span>
										</a>
									</div>
								</div>
							</div>
							<?php if($this->session->flashdata('success') != ""){ ?>
							<div class="alert alert-success alert-dismissible">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $this->session->flashdata('success');?>
							</div>	
							<?php }else if($this->session->flashdata('error') != ""){ ?>
							<div class="alert alert-danger alert-dismissible">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $this->session->flashdata('error');?>
							</div>	
							<?php } ?>
							<div class="table-header">
								List Penjualan
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<div>
								<table id="example" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Nomor Penjualan</th>
											<th>Tanggal Penjualan</th>
											<th>Nama Customer</th>
											<th>Total</th>
											<th>Discount</th>
											<th>GrandTotal</th>
											<th>DP 1</th>
											<th>DP 2</th>
											<th>Lunas</th>
											<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($header_penjualan as $key => $value) {
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
													if($value->metode_pembayaran == 2){
														if($value->dp1 == 0){
												?>
													<button type="button" class="btn btn-sm btn-primary dp1" headerpenjualan="<?php echo $value->id_header_penjualan;?>">
														DP 1
													</button>
												<?php 
														}else if($value->dp1 != 0 && $value->dp2 == 0){
												?>
													<a href="<?php echo base_url('penjualan/prints');?>">
													<button type="button" class="btn btn-sm btn-success" style="margin-bottom: 10px;">
														Print
													</button>
													</a>
													<p>Total : <?php if(!empty($value->dp1)){ echo number_format($value->dp1, 0, '', '.'); } ?></p>
												<?php
														}
													} 
												?>
											</td>
											<td>
												<?php 
													if($value->metode_pembayaran == 2){
														if($value->dp1 != 0 && $value->dp2 == 0){
												?>
													<button type="button" class="btn btn-sm btn-primary dp2" headerpenjualan="<?php echo $value->id_header_penjualan;?>">
														DP 2
													</button>
												<?php 
														}
													}
												?>
											</td>
											<td>
												<?php 
													if($value->metode_pembayaran == 1){
												?>
												<a href="<?php echo base_url('penjualan/prints');?>">
													<button type="button" class="btn btn-sm btn-success" style="margin-bottom: 10px;">
														Print
													</button>
												</a>
												<p>Total : <?php if(!empty($value->grandtotal)){ echo number_format($value->grandtotal, 0, '', '.'); } ?></p>
												<?php
													}else if($value->dp1 != 0 && $value->dp2 != 0){
												?>
													<a href="<?php echo base_url('penjualan/prints');?>">
														<button type="button" class="btn btn-sm btn-success" style="margin-bottom: 10px;">
															Print
														</button>
													</a>
													<p>Total : <?php if(!empty($value->grandtotal)){ echo number_format($value->grandtotal, 0, '', '.'); } ?></p>
												<?php
													} 
												?>
											</td>
											<td>
												<?php
													if((int)$value->status_pembayaran == 0){
												?>
													Belum Bayar
												<?php
													}else if((int)$value->status_pembayaran == 1){
												?>
													Lunas
												<?php }else{ ?>
													Masih DP	

												<?php } ?>
											</td>
											<td>
												<div class="hidden-sm hidden-xs action-buttons">
													<a class="blue" href="<?php echo base_url('penjualan/view/' . $value->id_header_penjualan);?>">
														<i class="ace-icon fa fa-search-plus bigger-130"></i>
													</a>
													<?php if($value->status_pembayaran != 1){ ?>
													<a class="green" href="<?php echo base_url('penjualan/detail/' . $value->id_header_penjualan)?>">
														<i class="ace-icon fa fa-pencil bigger-130"></i>
													</a>

													<a class="red delete" href="#" deleteid="<?php echo $value->id_header_penjualan;?>">
														<i class="ace-icon fa fa-trash-o bigger-130"></i>
													</a>
													<?php } ?>
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