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
					<li class="active">Lokasi</li>
				</ul><!-- /.breadcrumb -->
			</div>

			<div class="page-content">

				<div class="page-header">
					<h1>
						Lokasi
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Lokasi
						</small>
					</h1>
				</div>

				<div class="row">
					<div class="col-xs-12" style="margin-bottom:10px;">
						<a href="<?php echo base_url('location/index');?>">
							<button class="btn" type="button">
								<i class="ace-icon fa fa-undo"></i>
								Kembali
							</button>
						</a>
					</div>
					<div class="col-xs-12">
						<div class="table-header">
							Lihat Data Lokasi
						</div>
					</div>

					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->
						<form class="form-horizontal" role="form" style="margin: 15px 0px;">
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Kode Lokasi</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Kode Lokasi" class="form-control" disabled name="kode_lokasi" value="<?php echo $location->code_location;?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nama" class="form-control" disabled name="nama" value="<?php echo $location->name_location;?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Alamat</label>

								<div class="col-sm-9">
									<textarea name="alamat" rows="10" id="edi" cols="50" style="width: 100%" disabled><?php echo $location->address_location?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Email</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Email" class="form-control" required name="email" 
									value="<?php if(empty($inputs['email'])){ echo $location->email; }else{ echo $inputs['email'];}?>"/ disabled>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Telepon</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Telepon" class="form-control" required name="tlp" 
									value="<?php if(empty($inputs['tlp'])){ echo $location->tlp; }else{ echo $inputs['tlp'];}?>" disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama Bank</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nama Bank" class="form-control" required name="bank_account" 
									value="<?php if(!empty($inputs)){echo $inputs['bank_account'];}else{ echo $location->bank_account; }?>" disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama Rekening</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nama Rekening" class="form-control" required name="bank_account_name" 
									value="<?php if(!empty($inputs)){echo $inputs['bank_account_name'];}else{ echo $location->bank_account_name; }?>" disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nomor Rekening</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Nomor Rekening" class="form-control" required name="bank_no" 
									value="<?php if(!empty($inputs)){echo $inputs['bank_no'];}else{ echo $location->bank_no; }?>" disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Sosial Media</label>

								<div class="col-sm-9">
									<input type="text" id="form-field-1-1" placeholder="Instagram" class="form-control" required name="ig" 
									value="<?php if(empty($inputs['ig'])){ echo $location->ig; }else{ echo $inputs['ig'];}?>" disabled/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Status</label>

								<div class="col-sm-9">
									<select name="status"  data-placeholder="Click to Choose..." disabled>
										<?php if($location->status == 0){ ?>
											<option value="0" selected>Tidak Aktif</option>
											<option value="1">Aktif</option>
										<?php }else{ ?>
											<option value="0">Tidak Aktif</option>
											<option value="1" selected>Aktif</option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<a href="<?php echo base_url('location/index');?>">
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