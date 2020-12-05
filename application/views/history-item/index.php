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

				<!-- <div class="nav-search" id="nav-search">
					<form class="form-search">
						<span class="input-icon">
							<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</form>
				</div> -->
				<!-- /.nav-search -->
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
					<div class="col-xs-12">
						<div class="table-header">
							Daftar History Item
						</div>

						<!-- div.table-responsive -->

						<!-- div.dataTables_borderWrap -->
						<div class="tables">
							<table id="example" class="table table-striped table-bordered table-hover" style="width:100%;">
								<thead>
									<tr>
										<th>Item</th>
										<th>Harga</th>
										<th>Diubah Oleh</th>
                                        <th>Diubah Tanggal</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($history as $key => $value) {
									?>
									<tr>
										<td><?php echo $value->nama;?></td>
										<td><?php echo number_format($value->harga,0,'',',');?></td>
                                        <td><?php echo $value->username;?></td>
                                        <td><?php echo date('d-M-Y', strtotime($value->updated_date));?></td>
										<td>
											<div class="hidden-sm hidden-xs action-buttons">
												<a class="blue" href="<?php echo base_url('history_item/view/' . $value->id_history);?>">
													<i class="ace-icon fa fa-search-plus bigger-130"></i>
												</a>
											</div>
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