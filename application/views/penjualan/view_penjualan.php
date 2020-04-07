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
					<li class="active">Penjualan</li>
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
						Penjualan
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Penjualan pada application fotocopy
						</small>
					</h1>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="table-header">
							Data Penjualan
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
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nomor Penjualan</label>

								<div class="col-sm-9">
									<input type="text" placeholder="Nomor Penjualan" class="form-control" name="id_head" value="<?php echo $header_penjualan->id_header_penjualan;?>" disabled/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Tanggal Penjualan</label>

								<div class="col-sm-9">
									<input type="text" placeholder="Tanggal Penjualan" class="form-control" name="tgl_penjualan" value="<?php echo $header_penjualan->tgl_penjualan;?>" disabled/>
								</div>
							</div>
							<div class="clearfix form-actions">
							</div>
						</form>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="table-header">
							Item
						</div>

						<!-- div.dataTables_borderWrap -->
						<div>
							<table id="example" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Nama Item</th>
										<th>Satuan</th>
										<th>Jumlah</th>
										<th>Harga Satuan</th>
										<th>Total Harga</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($penjualan as $key => $value) {
									?>
										<tr>
											<td><?php echo $value->nama;?></td>
											<td><?php echo $value->satuan;?></td>
											<td><?php echo $value->qty;?></td>
											<td><?php echo $value->harga_satuan;?></td>
											<td><?php echo $value->total_harga;?></td>
										</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-xs-12">
						<a href="<?php echo base_url('penjualan/index');?>">
							<button class="btn" type="button" style="margin-top: 10px;">
								Back
							</button>
						</a>
					</div>
				</div><!-- /.row -->
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
	<?php $this->load->view('footer');?>
</div><!-- /.main-container -->
<?php $this->load->view('script_footer');?>