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
					<div class="col-xs-12" style="margin-bottom:10px;">
						<a href="<?php echo base_url('penjualan/index');?>">
							<button class="btn" type="button">
								<i class="ace-icon fa fa-undo"></i>
								Kembali
							</button>
						</a>
					</div>
					<div class="col-xs-12">
						<div class="table-header">
							Ubah Data Penjualan
						</div>
					</div>

					<div class="col-xs-12">
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
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nomor Penjualan</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-1-1" placeholder="Nomor Penjualan" class="form-control" name="id" value="<?php echo $header_penjualan->id_header_penjualan;?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Tanggal Penjualan</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-1-1" placeholder="Tanggal Penjualan" class="form-control" name="tgl_penjualan" value="<?php echo $header_penjualan->tgl_penjualan;?>" />
							</div>
						</div>
					</div>
				</div>
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>