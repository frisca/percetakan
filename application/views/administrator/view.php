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
					<li class="active">Administrator</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">

				<div class="page-header">
					<h1>
						Administrator
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Administrator
						</small>
					</h1>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="table-header">
							Lihat Data Administrator
						</div>
					</div>

					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->
						<form class="form-horizontal" role="form" style="margin: 15px 0px;">
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nama" class="form-control" disabled name="nama" value="<?php echo $user->nama;?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Username</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Username" class="form-control" name="username" value="<?php echo $user->username;?>" disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Passsword</label>

								<div class="col-sm-9">
									<input type="password" id="form-field-1-1" placeholder="Password" class="form-control" name="password" disabled />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Location</label>

								<div class="col-sm-9">
									<select name="id_location" class="select2" data-placeholder="Click to Choose...">
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
									</select>
								</div>
							</div>

							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<a href="<?php echo base_url('administrator/index');?>">
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