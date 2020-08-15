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
						<li>Report</li>
						<li class="active">Pengeluaran</li>
					</ul><!-- /.breadcrumb -->
				</div>
				<div class="page-content">
					<div class="page-header">
						<h1>
							Report Pengeluaran
							<small>
								<i class="ace-icon fa fa-angle-double-right"></i>
								Report Pengeluaran
							</small>
						</h1>
					</div>

					

					<div class="row">
							<div class="col-xs-12">
								<div class="table-header">
									Report Pengeluaran
								</div>
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<form method="post" action="<?php echo base_url('report_pengeluaran/search');?>">
								<div class="col-xs-3" style="margin-top:10px;margin-bottom:10px;">
									<input type="text" placeholder="Dari Tanggal" class="form-control" name="from_date" value="<?php if(!empty($from)){ echo date('d-m-Y', strtotime($from));}?>" id="from_date"/>
								</div>

								<div class="col-xs-3" style="margin-top:10px;margin-bottom:10px;">
									<input type="text" placeholder="Sampai Tanggal" class="form-control" name="to_date" value="<?php if(!empty($to)){ echo date('d-m-Y', strtotime($to));}?>" id="to_date"/>
								</div>

								<div class="col-xs-3" style="margin-top:10px;margin-bottom:10px;">
									<select name="status" class="form-control" data-placeholder="Pilih status ..." id="status" style="width: 100%">
										<?php if($status == "0"){?>
											<option value="-99">Pilih Status</option>
											<option value="0" selected>Open</option>
											<option value="1">Close</option>
										<?php }else if($status == "1"){?>
											<option value="-99">Pilih Status</option>
											<option value="0">Open</option>
											<option value="1" selected>Close</option>
										<?php }else{?>
											<option value="-99">Pilih Status</option>
											<option value="0">Open</option>
											<option value="1">Close</option>
										<?php } ?>
									</select>
								</div>

								<div class="col-xs-3" style="margin-top:10px;margin-bottom:10px;">
									<button type="submit" class="search btn btn-sm btn-success fa fa-search" style="margin-bottom: 10px;">
									<!-- Cari -->
									</button>
									<button type="button" class="csv_pengeluaran btn btn-sm btn-info fa fa-file-excel-o" style="margin-bottom: 10px;">
									<!-- Print -->
									</button>
								</div>
							</form>
							<div class="col-xs-12">
								<table id="example" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Nomor Pengeluaran</th>
											<th>Tanggal Pengeluaran</th>
											<th>Total</th>
											<th>Status Pengeluaran</th>
											<th>Tanggal Dibuat</th>
											<th>Dibuat Oleh</th>
											<th>Tanggal Diubah</th>
											<th>Diubah Oleh</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
                                    <?php
											$total = 0;
											foreach ($report as $key => $value) {
											$total = $total + $value->total;
										?>
										<tr>
											<td>
                                                <?php echo $value->id_header_pengeluaran;?>	
											</td>
											<td><?php echo date('d-m-Y', strtotime($value->tgl_pengeluaran));?></td>
                                            <td>
                                                <?php echo number_format($value->total, 0, '', '.');?>	
											</td>
                                            <td>
                                                <?php 
                                                    if($value->status == 0){
                                                        echo 'Open';
                                                    }else{
                                                        echo 'Close';
                                                    }
                                                ?>	
											</td>
                                            <td><?php echo date('d-m-Y', strtotime($value->created_date));?></td>
											<td>
												<?php
													if(!empty($user)){
														foreach ($user as $keys => $values) {
															if($values->id_user == $value->created_by){
																echo $values->nama;
															}
														}
													}
												?>
											</td>
											<td><?php if($value->updated_date != '0000-00-00 00:00:00'){ echo date('d-m-Y', strtotime($value->updated_date));}?></td>
											<td>
												<?php
													if(!empty($user)){
														foreach ($user as $keys => $values) {
															if($values->id_user == $value->updated_by){
																echo $values->nama;
															}
														}
													}
												?>
											</td>
											<td>
												<div class="hidden-sm hidden-xs action-buttons">
													<a class="blue" href="<?php echo base_url('report_pengeluaran/detail/' . $value->id_header_pengeluaran);?>"
													target="_blank">
														<i class="ace-icon fa fa-search-plus bigger-130"></i>
													</a>
													<button type="button" class="csv_det_pengeluaran btn btn-sm btn-info fa fa-file-excel-o" style="margin-bottom: 10px;"
													headerpengeluaran="<?php echo $value->id_header_pengeluaran;?>">
														<!-- <i class="ace-icon fa fa-file-excel-o bigger-130"></i> -->
													</button>
												</div>
											</td>
										</tr>
										<?php 
											}
										?>
									</tbody>
								</table>
							</div>

							<div class="col-xs-12" style="margin-top:20px;">
								<table id="example" class="table table-striped table-bordered table-hover">
									<tbody>
										<tr style="width:10%;">
											<th>Sum Total</th>
											<td><?php echo number_format($total, 0, '', '.');?></td>
										</tr>
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