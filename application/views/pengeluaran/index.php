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
						<li class="active">Pengeluaran</li>
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
							Pengeluaran
							<small>
								<i class="ace-icon fa fa-angle-double-right"></i>
								Pengeluaran pada application fotocopy
							</small>
						</h1>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<div class="clearfix">
								<div class="pull-right tableTools-container">
									<div class="dt-buttons btn-overlap btn-group">
										<a class="dt-button buttons-collection buttons-colvis btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table" href="<?php echo base_url('pengeluaran/add');?>">
											<span><i class="fa fa-plus bigger-110 blue"></i> 
												<span class="hidden">Add Data Pengeluaran</span>
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
								List Pengeluaran
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<div>
								<table id="example" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Nomor Pengeluaran</th>
											<th>Tanggal Pengeluaran</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($header_pengeluaran as $key => $value) {
										?>
										<tr>
											<td><?php echo $value->id_header_pengeluaran;?></td>
											<td><?php echo $value->tgl_pengeluaran;?></td>
											<td>
												<!-- <div class="hidden-sm hidden-xs action-buttons">
													<a class="blue" href="<?php echo base_url('penjualan/view/' . $value->id_header_penjualan);?>">
														<i class="ace-icon fa fa-search-plus bigger-130"></i>
													</a>

													<a class="green" href="<?php echo base_url('penjualan/detail/' . $value->id_header_penjualan)?>">
														<i class="ace-icon fa fa-pencil bigger-130"></i>
													</a>

													<a class="red" href="<?php echo base_url('penjualan/deletes/' . $value->id_header_penjualan);?>">
														<i class="ace-icon fa fa-trash-o bigger-130"></i>
													</a>
												</div> -->
											</td>
										</tr>
										<?php 
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->

		<?php $this->load->view('footer');?>
	</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>