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

				<div class="row">
					<div class="col-xs-12">
						<div class="clearfix">
							<div class="pull-right tableTools-container">
								<div class="dt-buttons btn-overlap btn-group">
									<a class="dt-button buttons-collection buttons-colvis btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table" data-original-title="" title="" href="<?php echo base_url('operator/add');?>">
										<span><i class="fa fa-plus bigger-110 blue"></i> 
											<span class="hidden">Tambah Data Operator</span>
										</span>
									</a>
								</div>
							</div>
						</div>
						<?php if($this->session->flashdata('success') != ""){ ?>
						<div class="alert alert-success alert-dismissible">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?php echo $this->session->flashdata('success');?>
						</div>	
						<?php }else if($this->session->flashdata('error') != ""){ ?>
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?php echo $this->session->flashdata('error');?>
						</div>	
						<?php } ?>
						<div class="table-header">
							Daftar Operator
						</div>

						<!-- div.table-responsive -->

						<!-- div.dataTables_borderWrap -->
						<div class="tables">
							<table id="example" class="table table-striped table-bordered table-hover" style="width:100%;">
								<thead>
									<tr>
										<th>Nama</th>
										<th>Username</th>
										<th>Status</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($user as $key => $value) {
									?>
									<tr>
										<td><?php echo $value->nama;?></td>
										<td><?php echo $value->username?></td>
										<td>
											<?php 
												if($value->status == 0){ 
													echo "Tidak Aktif";
												}else{
													echo "Aktif";
												}
											?>
										</td>
										<td>
											<div class="hidden-sm hidden-xs action-buttons">
												<a class="blue" href="<?php echo base_url('operator/view/' . $value->id_user);?>">
													<i class="ace-icon fa fa-search-plus bigger-130"></i>
												</a>

												<a class="green" href="<?php echo base_url('operator/edit/' . $value->id_user)?>">
													<i class="ace-icon fa fa-pencil bigger-130"></i>
												</a>

												<a class="red delete" href="#" deleteid="<?php echo $value->id_user;?>">
													<i class="ace-icon fa fa-trash-o bigger-130"></i>
												</a>
											</div>
										</td>
									</tr>
									<?php 
										}
									?>
								</tbody>
							</table>

							<div id="delete_modal" class="modal">
								<div class="modal-dialog">
									<div class="modal-content">
										<!-- Modal Header -->
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Hapus Operator</h4>
										</div>
										<form action="<?php echo base_url('operator/delete')?>" method="post">
											<input type="hidden" class="form-control" name="id" value="" />
											<div class="modal-body">
												<p>Apakah Anda yakin ingin menghapus data ini?</p>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-primary">Hapus</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal" id="batalPenjualan">Batal</button>
											</div>
										</form>
									</div>
								</div>
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