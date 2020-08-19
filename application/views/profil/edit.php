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
					<li class="active">Profil</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">

				<div class="page-header">
					<h1>
						Profil
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Profil
						</small>
					</h1>
				</div>

				<?php
					$inputs = $this->session->flashdata('inputs');
				?>

				<div class="row">
					<div class="col-xs-12" style="margin-bottom:10px;">
						<a href="<?php echo base_url('home/index');?>">
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

                        <?php if($this->session->flashdata('success') != ""){?>
							<div class="alert alert-success form-group">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $this->session->flashdata('success');?>
							</div>
						<?php } ?>
						
						<div class="table-header">
							Ubah Data Profil
						</div>
					</div>

					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->
						<form class="form-horizontal" role="form" style="margin: 15px 0px;" action="<?php echo base_url('profil/processEdit');?>" method="post">
							<input type="hidden" class="form-control" name="id" value="<?php echo $user->id_user;?>" />
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nama" class="form-control" name="nama" 
									value="<?php if(empty($inputs['nama'])) { echo $user->nama; }else{ echo $inputs['nama']; }?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Username</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Username" class="form-control" name="username" 
									value="<?php if(empty($inputs['username'])) { echo $user->username; }else{ echo $inputs['username']; }?>"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Passsword</label>

								<div class="col-sm-9">
									<input type="password" id="form-field-1-1" placeholder="Password" class="form-control" name="password"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Location</label>

								<div class="col-sm-9">
									<select name="id_location" class="select2" data-placeholder="Click to Choose...">
										<?php if(empty($inputs['id_location'])) { ?>
											<?php 
												foreach ($location as $key => $value) {
													if($user->id_location == $value->id_location){
											?>
												<option value="<?php echo $value->id_location;?>" selected><?php echo $value->nama_location;?></option>
											<?php 
												}else{ 
											?>
												<option value="<?php echo $value->id_location;?>"><?php echo $value->nama_location;?></option>
											<?php 
													}
												}
											?>
										<?php }else{ ?>
											<?php 
												foreach ($location as $key => $value) {
													if($inputs['id_location'] == $value->id_location){
											?>
														<option value="<?php echo $value->id_location;?>" selected><?php echo $value->nama_location;?></option>
											<?php
													}else{
											?>
														<option value="<?php echo $value->id_location;?>"><?php echo $value->nama_location;?></option>
											<?php 
													}
												}
											?>
										<?php } ?>
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
									<a href="<?php echo base_url('home/index');?>">
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