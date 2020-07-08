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
					<li class="active">User</li>
					<li class="active">Item</li>
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
						Item
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Item
						</small>
					</h1>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="table-header">
							Lihat Data Item
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
						
						<form class="form-horizontal" role="form" style="margin: 15px 0px;">
							<input type="hidden" name="id" value="<?php echo $item->id_item;?>"/>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nama" class="form-control" required name="nama" value="<?php echo $item->nama;?>" disabled />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Satuan</label>

								<div class="col-sm-9">
									<select name="id_satuan" class="select2" data-placeholder="Click to Choose..." disabled>
										<?php 
											foreach ($satuan as $key => $value) {
												if($value->id_satuan == $item->id_satuan){
										?>
											<option value="<?php echo $value->id_satuan;?>" selected><?php echo $value->satuan;?></option>
										<?php 
												}else{
										?>
											<option value="<?php echo $value->id_satuan;?>"><?php echo $value->satuan;?></option>
										<?php
												}
											}
										?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Harga</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Harga" class="form-control" name="hargas" required value="<?php echo $item->harga;?>" disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Desain</label>

								<div class="col-sm-9">
									<select name="is_design"  data-placeholder="Click to Choose..." disabled>
										<?php 
											if($item->is_design == 0){
										?>
											<option value=0 selected>Tidak</option>
											<option value=1>Ya</option>
										<?php 
											}else{
										?>
											<option value=0>Tidak</option>
											<option value=1 selected>Ya</option>
										<?php 
											}
										?>
									</select>
								</div>
							</div>

							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<a href="<?php echo base_url('item/index');?>">
										<button class="btn" type="button">
											<i class="ace-icon fa fa-undo"></i>
											Back
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