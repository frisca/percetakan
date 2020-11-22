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
					<li class="active">Customer</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">
				<div class="page-header">
					<h1>
						Customer
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Customer
						</small>
					</h1>
				</div>

				<?php
					$inputs = $this->session->flashdata('inputs');
				?>

				<div class="row">
					<div class="col-xs-12" style="margin-bottom:10px;">
						<a href="<?php echo base_url('customer/index');?>">
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
							Lihat Data Customer
						</div>
					</div>

					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->			
						<form class="form-horizontal" role="form" style="margin: 15px 0px;">
                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">First Name</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="First Name" class="form-control" required name="first_name" 
                                    value="<?php if(empty($inputs['first_name'])){ echo $customer->first_name; }else{ echo $inputs['first_name']; }?>"
                                    disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Last Name</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Last Name" class="form-control" required name="last_name" 
                                    value="<?php if(empty($inputs['last_name'])){ echo $customer->last_name; }else{ echo $inputs['last_name']; }?>"
                                    disabled/>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Address 1</label>

								<div class="col-sm-9">
									<textarea name="address_1" rows="10" cols="50" style="width: 100%"
                                    disabled><?php if(empty($inputs['address_1'])){ echo $customer->address_1; }else{ echo $inputs['address_1']; }?></textarea>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Address 2</label>

								<div class="col-sm-9">
									<textarea name="address_2" rows="10" cols="50" style="width: 100%"
                                    disabled><?php if(empty($inputs['address_2'])){ echo $customer->address_2; }else{ echo $inputs['address_2']; }?></textarea>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1" >Phone 1</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Phone 1" class="form-control" name="phone_1" 
                                    value="<?php if(empty($inputs['phone_1'])){ echo $customer->phone_1; }else{ echo $inputs['phone_1']; }?>"
                                    disabled/>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Phone 2</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Phone 2" class="form-control" name="phone_2" 
                                    value="<?php if(empty($inputs['phone_2'])){ echo $customer->phone_2; }else{ echo $inputs['phone_2']; }?>"
                                    disabled/>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Email</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Email" class="form-control" name="email" 
                                    value="<?php if(empty($inputs['email'])){ echo $customer->email; }else{ echo $inputs['email']; }?>"
                                    disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Status</label>

								<div class="col-sm-9">
									<select name="status"  data-placeholder="Click to Choose..." disabled>
										<?php 
											if(empty($inputs['status'])){
										?>
											<?php if($customer->status == 0){?>
												<option value="0" selected>Tidak Aktif</option>
												<option value="1">Aktif</option>
											<?php }else{ ?>
												<option value="0">Tidak Aktif</option>
												<option value="1" selected>Aktif</option>
											<?php }?>
										<?php
											}else{
										?>
											<?php
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
											?>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<a href="<?php echo base_url('customer/index');?>">
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