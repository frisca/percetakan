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
						<a href="#">Beranda</a>
					</li>
					<li class="active">Pengeluaran</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">
				<div class="page-header">
					<h1>
						Pengeluaran
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Pengeluaran
						</small>
					</h1>
				</div>

				<div class="row">
					<div class="col-xs-12" style="margin-bottom:10px;">
						<a href="<?php echo base_url('pengeluaran/index');?>">
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

						<?php if($this->session->flashdata('succes') != ""){?>
							<div class="alert alert-success form-group">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $this->session->flashdata('success');?>
							</div>
						<?php } ?>
					</div>
						
					<div class="col-xs-12">
						<div class="table-header">
							Data Pengeluaran
						</div>
					</div>

					<!-- <div class="col-xs-12"> -->
						<!-- PAGE CONTENT BEGINS -->
						
					<form style="margin-top:50px;" method="post" action="<?php echo base_url('pengeluaran/checkout/' . $header_pengeluaran->id_header_pengeluaran);?>">
						<div class="col-sm-6 form-group">
							<label>Nomor Pengeluaran</label>
							<?php 
								if($header_pengeluaran->status == 0){
							?>
							<input type="text" placeholder="Nomor Pengeluaran" class="form-control" name="id_head" value="<?php echo $header_pengeluaran->id_header_pengeluaran;?>" disabled/>
							<?php
								}else{
							?>
							<input type="text" placeholder="Nomor Pengeluaran" class="form-control" name="id_head" value="<?php echo $header_pengeluaran->nomor_pengeluaran;?>" disabled/>
							<?php
								}
							?>
						</div>
						<div class="col-sm-6 form-group">
							<label>Tanggal Pengeluaran</label>
							<input type="text" placeholder="Tanggal Pengeluaran" class="form-control" name="tgl_pengeluaran" value="<?php echo date('d-m-Y', strtotime($header_pengeluaran->tgl_pengeluaran));?>" id="tgl_pengeluaran">
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
							<input type="text" placeholder="Total" class="form-control" name="totals" value="<?php echo number_format($header_pengeluaran->total,0,'',',');?>" disabled>
						</div>
						<!-- </div> -->
					</div>

					<div class="row">
						<div class="col-xs-12">
							<div class="table-header">
								Item
								<?php
									if($header_pengeluaran->status == 0){
								?>
								<div class="pull-right tableTools-container">
									<div class="dt-buttons btn-overlap btn-group" style="margin: 1px 5px 5px 0px;">
										<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal" type="button">Tambah</button>
									</div>
								</div>
								<?php
									}
								?>
							</div>

							<!-- div.dataTables_borderWrap -->
							<div>
								<table id="example" class="table table-striped table-bordered table-hover" style="width:100%;">
									<thead>
										<tr>
											<th>Nama Item</th>
											<th>Harga</th>
											<th>Keterangan</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($pengeluaran as $key => $value) {
										?>
										<tr>
											<td><?php echo $value->item;?></td>
											<td><?php echo number_format($value->price, 0, '', ',');?></td>
											<td><?php echo $value->keterangan;?></td>
											<td>
												<?php 
													if($value->status == 0){
												?>
													<div class="hidden-sm hidden-xs action-buttons">
														<a class="green edit_pengeluaran" href="#" pengeluaranid="<?php echo $value->id_pengeluaran;?>">
															<i class="ace-icon fa fa-pencil bigger-130"></i>
														</a>

														<a class="red delete" href="#" deleteid="<?php echo $value->id_pengeluaran;?>">
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
							<?php
								if($header_pengeluaran->status == 0){
							?>
								<button class="btn btn-primary" type="submit" style="margin-top: 10px;">
									Checkout
								</button>
							<?php
								}
							?>
							<a href="<?php echo base_url('pengeluaran/index');?>">
								<button class="btn" type="button" style="margin-top: 10px;">
									Kembali
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
					        <form action="<?php echo base_url('pengeluaran/processAddPengeluaran')?>" method="post">
					        	<div class="modal-body">
					            	<div class="row">
					            		<input type="hidden" class="form-control" name="id_header_pengeluaran" value="<?php echo $header_pengeluaran->id_header_pengeluaran;?>" />
					            		<div class="col-sm-12 form-group">
											<label>Nama Item</label>
											<input type="text" class="form-control" name="item" value="" required />
										</div>
										<div class="col-sm-12 form-group">
											<label>Harga</label>
											<input type="text" class="form-control harga_item" name="harga" value="" required />
										</div>
										<div class="col-sm-12 form-group">
											<label>Keterangan</label>
											<input type="text" class="form-control" name="keterangan" value=""/>
										</div>
					            	</div>
					            </div>
					            <div class="modal-footer">
						        	<button type="submit" class="btn btn-primary">Simpan</button>
						            <button type="button" class="btn btn-danger" data-dismiss="modal" id="batalPenjualan">Batal</button>
						        </div>
					        </form>
					    </div>
				    </div>
				</div>

				<!-- The Modal -->
				<div id="show_modal" class="modal">
				    <div class="modal-dialog">
					    <div class="modal-content">
					        <!-- Modal Header -->
					        <div class="modal-header">
					          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        					<h4 class="modal-title">Ubah Item</h4>
					        </div>
					        <form action="<?php echo base_url('pengeluaran/processEditPengeluaran')?>" method="post">
					        	<div class="modal-body">
					            	<div class="row">
					            		<input type="hidden" class="form-control" name="id_header_pengeluaran" value="" />
					            		<input type="hidden" class="form-control" name="id_pengeluaran" value="" />

					            		<div class="col-sm-12 form-group">
											<label>Nama Item</label>
											<input type="text" class="form-control" name="item" value="" required />
										</div>
										<div class="col-sm-12 form-group">
											<label>Harga</label>
											<input type="text" class="form-control harga_item" name="harga" value="" required />
										</div>
										<div class="col-sm-12 form-group">
											<label>Keterangan</label>
											<input type="text" class="form-control" name="keterangan" value=""/>
										</div>
					            	</div>
					            </div>
					            <div class="modal-footer">
						        	<button type="submit" class="btn btn-primary">Simpan</button>
						            <button type="button" class="btn btn-danger" data-dismiss="modal" id="batalPenjualan">Batal</button>
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
	        					<h4 class="modal-title">Hapus Item</h4>
					        </div>
					        <form action="<?php echo base_url('pengeluaran/deleteItem')?>" method="post">
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
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>