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
					<li class="active">Pengeluaran</li>
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
						Pengeluaran
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Pengeluaran
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
							Data Pengeluaran
						</div>
					</div>

					<!-- <div class="col-xs-12"> -->
						<!-- PAGE CONTENT BEGINS -->
						
					<form style="margin-top:50px;" method="post" action="<?php echo base_url('pengeluaran/checkout/' . $header_pengeluaran->id_header_pengeluaran);?>">
						<div class="col-sm-6 form-group">
							<label>Nomor Pengeluaran</label>
							<input type="text" placeholder="Nomor Pengeluaran" class="form-control" name="id_head" value="<?php echo $header_pengeluaran->id_header_pengeluaran;?>" disabled/>
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
							<input type="text" placeholder="Total" class="form-control" name="totals" value="<?php echo number_format($header_pengeluaran->total,0,'','.');?>" disabled>
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
								<table id="example" class="table table-striped table-bordered table-hover">
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
											<td><?php echo number_format($value->price, 0, '', '.');?></td>
											<td><?php echo $value->keterangan;?></td>
										</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xs-12">
							<a href="<?php echo base_url('pengeluaran/index');?>">
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