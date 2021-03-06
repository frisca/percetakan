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
						<div class="table-header">
							Tambah Data Pengeluaran
						</div>
					</div>

					<!-- <div class="col-xs-12"> -->
						<!-- PAGE CONTENT BEGINS -->
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
						
						<form method="post" action="<?php echo base_url('pengeluaran/processAdd');?>" style="margin-top:50px;">
							<input type="hidden" class="form-control" name="id_header_pengeluaran" value="<?php echo $id_header_pengeluaran;?>"/>
							<div class="col-sm-6 form-group">
								<label>Nomor Pengeluaran</label>
								<input type="text" placeholder="Nomor Pengeluaran" class="form-control" name="id_head" value="<?php echo $id_header_pengeluaran;?>" disabled/>
							</div>
							<div class="col-sm-6 form-group">
								<label>Tanggal Pengeluaran</label>
								<input type="text" placeholder="Tanggal Pengeluaran" class="form-control" name="tgl_pengeluaran" value="<?php echo date('d-m-Y', strtotime($tgl_pengeluaran));?>" required id="tgl_transaksi"/>
							</div>
							<div class="col-sm-6 form-group">
								<label>Dibuat Oleh</label>
								<input type="text" placeholder="Dibuat Oleh" class="form-control" name="createdBy" value="<?php echo $user->nama;?>" disabled/>
							</div>
							<div class="col-sm-6 form-group">
								<label>Dibuat Tanggal</label>
								<input type="text" placeholder="Dibuat Tanggal" class="form-control" name="createdDates" value="<?php
								date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s');?>" disabled/>
							</div>
							<input type="hidden"  class="form-control" name="createdDate" value="<?php
							date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s');?>"/>
							<div class="col-xs-12">
								<div class="form-actions">
									<button class="btn btn-info" type="submit">
										<i class="ace-icon fa fa-check bigger-110"></i>
										Simpan
									</button>

									&nbsp; &nbsp; &nbsp;
									<a href="<?php echo base_url('pengeluaran/index');?>">
										<button class="btn" type="button">
											<i class="ace-icon fa fa-undo bigger-110"></i>
											Kembali
										</button>
									</a>
								</div>
							</div>
						</form>
					<!-- </div> -->
				</div>
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>