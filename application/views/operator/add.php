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
					<li class="active">User</li>
					<li class="active">Operator</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">
				<div class="page-header">
					<h1>
						Operator
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Operator
						</small>
					</h1>
				</div>

				<?php
					$inputs = $this->session->flashdata('inputs');
					// var_dump($this->session->flashdata('inputs'));exit();
				?>

				<div class="row">
					<div class="col-xs-12" style="margin-bottom:10px;">
						<a href="<?php echo base_url('operator/index');?>">
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
						
						<div class="table-header">
							Tambah Data Operator
						</div>
					</div>

					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->
						<form class="form-horizontal" role="form" style="margin: 15px 0px;" method="post" action="<?php echo base_url('operator/processAdd');?>">
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nama" class="form-control" required name="nama" 
									value="<?php if(!empty($inputs)){ echo $inputs['nama'];}?>"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Username</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Username" class="form-control" name="username" required
									value="<?php if(!empty($inputs)){echo $inputs['username'];}?>"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Passsword</label>

								<div class="col-sm-9">
									<input type="password" id="form-field-1-1" placeholder="Password" class="form-control" name="password" required />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Lokasi</label>

								<div class="col-sm-9">
									<select name="id_location" class="select2" data-placeholder="Click to Choose...">
										<option value="">Pilih Lokasi</option>
										<?php 
											foreach ($location as $key => $value) {
												if(!empty($inputs['id_location'])){
													if($inputs['id_location'] == $value->id_location){
										?>
													<option value="<?php echo $value->id_location;?>" selected><?php echo $value->name_location;?></option>
										<?php
													}else{
										?>
													<option value="<?php echo $value->id_location;?>"><?php echo $value->name_location;?></option>
										<?php 
													}
												}else{
										?>
													<option value="<?php echo $value->id_location;?>"><?php echo $value->name_location;?></option>
										<?php
												}
											}
										?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Status</label>

								<div class="col-sm-9">
									<select name="status"  data-placeholder="Click to Choose...">
										<?php
										if(!empty($inputs)){
											if($inputs['status'] == 0){
										?>
											<option value="0" selected>Tidak Aktif</option>
											<option value="1">Aktif</option>
										<?php
											}else{
										?>
											<option value="0">Tidak Aktif</option>
											<option value="1" selected>Aktif</option>
										<?php
											}
										}else{
										?>
											<option value="0">Tidak Aktif</option>
											<option value="1">Aktif</option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button class="btn btn-info" type="submit">
										<i class="ace-icon fa fa-check bigger-110"></i>
										Simpan
									</button>

									&nbsp; &nbsp; &nbsp;
									<a href="<?php echo base_url('operator/index');?>">
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