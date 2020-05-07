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
						<input type="text" placeholder="Nomor Penjualan" class="form-control" name="id_head" value="<?php echo $header_penjualan->id_header_penjualan;?>" disabled/>
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
						<input type="text" placeholder="Total" class="form-control" name="totals" value="<?php echo $header_penjualan->total;?>" disabled>
						<input type="hidden"  name="total" value="<?php echo $header_penjualan->total;?>">
					</div>
					<div class="col-sm-6 form-group">
						<label>Discount</label>
						<input type="text" placeholder="Discount" class="form-control discount" name="discount" value="<?php echo $header_penjualan->discount;?>">
					</div>
					<div class="col-sm-6 form-group">
						<label>Grand Total</label>
						<input type="text" placeholder="Total" class="form-control" name="grandtotals" value="<?php echo $header_penjualan->grandtotal;?>" disabled>
						<input type="hidden" name="grandtotal" value="<?php echo $header_penjualan->grandtotal;?>">
					</div>
					<div class="col-sm-6 form-group">
						<label>Metode Pembayaran</label>
						<select name="metode_pembayaran" class="metode_pembayaran" data-placeholder="Click to Choose..." class="form-control metode_pembayaran" style="width: 100%" required>
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
					<!-- </div> -->
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="table-header">
							Item
							<div class="pull-right tableTools-container">
								<div class="dt-buttons btn-overlap btn-group" style="margin: 1px 5px 5px 0px;">
									<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal" type="button">Tambah</button>
								</div>
							</div>
						</div>

						<!-- div.dataTables_borderWrap -->
						<div>
							<table id="example" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Nama Item</th>
										<th>Satuan</th>
										<th>Jumlah</th>
										<th>Harga Satuan</th>
										<th>Total Harga</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($penjualan as $key => $value) {
									?>
										<tr>
											<td><?php echo $value->nama;?></td>
											<td><?php echo $value->satuan;?></td>
											<td><?php echo $value->qty;?></td>
											<td><?php echo $value->harga_satuan;?></td>
											<td><?php echo $value->total_harga;?></td>
											<td>
												<?php 
													if($value->status == 0){
												?>
													<div class="hidden-sm hidden-xs action-buttons">
														<a class="green edit" href="#" penjualanid="<?php echo $value->id_penjualan;?>">
															<i class="ace-icon fa fa-pencil bigger-130"></i>
														</a>

														<a class="red" href="<?php echo base_url('penjualan/delete/' . $value->id_penjualan . '/' . $value->id_header_penjualan);?>">
															<i class="ace-icon fa fa-trash-o bigger-130"></i>
														</a>
													</div>
												<?php 
													}
												?>
											</td>
										</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-xs-12">
							<!-- <a class="yellow" href="<?php echo base_url('penjualan/checkout/' . $value->id_penjualan . '/' . $value->id_header_penjualan);?>">
															<i class="ace-icon fa fa-check-square-o bigger-130"></i>
														</a> -->
						<?php
							if($counts != 0){
						?>
							<button class="btn btn-primary checkout" type="submit" style="margin-top: 10px;">
								Checkout
							</button>
						<?php
							}
						?>
							<a href="<?php echo base_url('penjualan/index');?>">
								<button class="btn" type="button" style="margin-top: 10px;">
									Back
								</button>
							</a>
					</div>
				</form>
				</div><!-- /.row -->

				<!-- The Modal -->
				<div class="modal" id="myModal">
				    <div class="modal-dialog">
				      <div class="modal-content">
				      
				        <!-- Modal Header -->
				        <div class="modal-header">
				          	<button type="button" class="close" data-dismiss="modal">&times;</button>
        					<h4 class="modal-title">Tambah Item</h4>
				        </div>
				        <form action="<?php echo base_url('penjualan/processAddPenjualan')?>" method="post" enctype="multipart/form-data">
					        <!-- Modal body -->
					        <div class="modal-body">
					            <div class="row">
					            	<input type="hidden" class="form-control" name="id_header_penjualan" value="<?php echo $header_penjualan->id_header_penjualan;?>" />
					            	<input type="hidden" name="discount" value="<?php echo $header_penjualan->discount;?>" class="form-control discount">
					            	<input type="hidden" name="metode_pembayaran" value="<?php echo $header_penjualan->metode_pembayaran;?>">
					            	<input type="hidden" name="grandtotal" value="<?php echo $header_penjualan->grandtotal;?>">
					            	<input type="hidden" class="form-control satuan" name="id_satuan" value="" />
					            	<input type="hidden" class="form-control harga" name="harga_satuan" value="" />
					            	<input type="hidden" class="form-control" name="tgl_penjualan" value="<?php echo date('d-m-Y', strtotime($header_penjualan->tgl_penjualan));?>" id="transaksiDate">
					            	<input type="hidden" id="total_harga" placeholder="Total Harga" class="form-control" name="total_harga" value="" required />
					            	<div class="col-sm-12 form-group">
										<label>Nama Item</label>
										<select name="id_item" class="select2 id_item" data-placeholder="Click to Choose..." class="form-control" style="width: 100%" required>
											<?php 
												foreach ($item as $key => $value) {
											?>
												<option value="<?php echo $value->id_item;?>" satuanid="<?php echo $value->id_satuan;?>" hargasatuan="<?php echo $value->harga;?>"><?php echo $value->nama;?></option>
											<?php 
												}
											?>
										</select>
									</div>
									<div class="col-sm-12 form-group">
										<label>Satuan</label>
										<input type="text" class="form-control satuan" name="satuan" value="" disabled />
										<!-- <select name="satuan" class="select2 satuan" data-placeholder="Click to Choose..." class="form-control" style="width: 100%" required disabled>
											<?php 
												foreach ($satuan as $key => $value) {
											?>
												<option value="<?php echo $value->id_satuan;?>"><?php echo $value->satuan;?></option>
											<?php 
												}
											?>
										</select> -->
									</div>
									<div class="col-sm-12 form-group images" style="display: none;">
										<label>Line Item</label>
										<input type="file" class="form-control" name="line_item" />
									</div>
									<div class="col-sm-12 form-group">
										<label>Harga Satuan</label>
										<input type="text" id="hrga_satuan" placeholder="Harga Satuan" class="form-control" name="harga" required disabled />
									</div>
									<div class="col-sm-12 form-group">
										<label>Jumlah</label>
										<input type="text" id="qty" placeholder="Jumlah" class="form-control" name="qty" required />
									</div>
									<div class="col-sm-12 form-group">
										<label>Total Harga</label>
										<input type="text" id="ttl_harga" placeholder="Total Harga" class="form-control" name="ttl_harga" value="" required disabled />
									</div>
					            </div>
					        </div>
					        <!-- Modal footer -->
					        <div class="modal-footer">
					        	<button type="submit" class="btn btn-primary">Simpan</button>
					            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
					        </div>
				        </form>
				      </div>
				    </div>
				</div>

				<div id="show_modal" class="modal">
				  	<div class="modal-dialog">
					    <div class="modal-content">
					      	<div class="modal-header">
					          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        					<h4 class="modal-title">Edit Item</h4>
					        </div>
					        <form action="<?php echo base_url('penjualan/processEditPenjualan')?>" method="post" enctype="multipart/form-data">
						      	<div class="modal-body">
							        <div class="row">
						            	<input type="hidden" class="form-control" name="id_penjualan" value="" id="id_penjualan" />
						            	<input type="hidden" class="form-control" name="id_header_penjualan" value="" id="id_header_penjualan" />
						            	<input type="hidden" name="discount" value="<?php echo $header_penjualan->discount;?>" class="form-control discount">
					            		<input type="hidden" name="metode_pembayaran" value="<?php echo $header_penjualan->metode_pembayaran;?>">
					            		<input type="hidden" name="grandtotal" value="<?php echo $header_penjualan->grandtotal;?>">
					            		<input type="hidden" name="harga_satuan" value="" />
					            		<input type="hidden" name="total_harga" value="" />
					            		<input type="hidden" class="form-control satuan" name="id_satuan" value="" />
					            		<input type="hidden" class="form-control" name="tgl_penjualan" value="<?php echo date('d-m-Y', strtotime($header_penjualan->tgl_penjualan));?>" id="transaksiDate">
						            	<div class="col-sm-12 form-group">
											<label>Nama Item</label>
											<select name="id_item" class="select2" id="item" data-placeholder="Click to Choose..." style="width: 100%" required>
												<?php 
													foreach ($item as $key => $value) {
												?>
													<option value="<?php echo $value->id_item;?>"><?php echo $value->nama;?></option>
												<?php 
													}
												?>
											</select>
										</div>
										<div class="col-sm-12 form-group">
											<label>Satuan</label>
											<input type="text" class="form-control satuan" name="satuan" value="" disabled />
										</div>
										<div class="col-sm-12 images" style="display: none;">
											<label>Line Item</label>
											<div>
												<img id="my_image" src="" style="width: 150px;height: 150px;margin-bottom: 10px;" />
											</div>
											<input type="file" class="form-control" name="line_item" />
										</div>
										<div class="col-sm-12 form-group">
											<label>Harga Satuan</label>
											<input type="text" id="harga_satuan" placeholder="Harga Satuan" class="form-control" name="hargas_satuan" required value="" disabled />
										</div>
										<div class="col-sm-12 form-group">
											<label>Jumlah</label>
											<input type="text" id="quantity" placeholder="Jumlah" class="form-control" name="qty" required value="" />
										</div>
										<div class="col-sm-12 form-group">
											<label>Total Harga</label>
											<input type="text" id="total_hargas" placeholder="Total Harga" class="form-control" name="ttls_harga" value="" required disabled />
										</div>
						            </div>
						      	</div>
						      	<div class="modal-footer">
						        	<button type="submit" class="btn btn-primary">Simpan</button>
						            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
						      	</div>
					        </form>
					    </div>
				  	</div>
				</div>
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>