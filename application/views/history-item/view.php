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
					<li class="active">History Item</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">

				<div class="page-header">
					<h1>
						History Item
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							History Item
						</small>
					</h1>
				</div>

				<div class="row">
					<div class="col-xs-12" style="margin-bottom:10px;">
						<a href="<?php echo base_url('satuan/index');?>">
							<button class="btn" type="button">
								<i class="ace-icon fa fa-undo"></i>
								Kembali
							</button>
						</a>
					</div>

					<div class="col-xs-12">
						<div class="table-header">
							Lihat Data History item
						</div>
					</div>

					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->
						<form class="form-horizontal" role="form" style="margin: 15px 0px;">
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Item</label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nama" class="form-control" name="item" value="<?php echo $history->nama;?>" 
                                    disabled/>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Harga</label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Harga" class="form-control" name="harga" value="<?php echo number_format($history->harga,0,'',',');?>" 
                                    disabled/>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Diubah Oleh</label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Diubah Oleh" class="form-control" name="updated_by" value="<?php echo $history->username;?>" 
                                    disabled/>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Diubah Tanggal</label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Diubah Tanggal" class="form-control" name="updated_date" value="<?php echo date('d-M-Y', strtotime($history->updated_date));?>" 
                                    disabled/>
								</div>
							</div>

							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<a href="<?php echo base_url('history_item/index');?>">
										<button class="btn" type="button">
											<i class="ace-icon fa fa-undo"></i>
											Kembali
										</button>
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>