
		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.jqGrid.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/grid.locale-en.js"></script>

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="<?php echo base_url();?>assets/js/jquery-ui.custom.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.easypiechart.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.sparkline.index.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.flot.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.flot.pie.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/autoNumeric.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			$(document).ready(function(){
				$('#example').DataTable();

				// $('#savePenjualan').click(function(){
				// 	if($('#qty').val()){
				// 		alert('Jumlah Tidak boleh kosonog');
				// 		return false;
				// 	}
				// });

				$('#qty').keyup(function(){
					// $('input[name="total_harga"]').val('');
					if(this.value.length == 0){
						$('input[name="total_harga"]').val('');
						$('input[name="ttl_harga"]').val('');
					}
					if($('#hrga_satuan').val() != '' && $('#qty').val() != ''){
						var total_harga = parseInt($('#hrga_satuan').autoNumeric('get'), 10) * parseInt($('#qty').val(), 10);
						$('input[name="total_harga"]').val(total_harga);
						$('input[name="ttl_harga"]').val(total_harga).autoNumeric('init');
					}
				});

				$('#quantity').keyup(function(){
					$('#total_hargas').val('');
					if(this.value.length == 0){
						$('#total_hargas').val('');
						$('input[name="total_harga"]').val('');
						return false;
					}
					if($('#harga_satuan').val() != '' && $('#quantity').val() != ''){
						var total_harga = parseInt($('#harga_satuan').autoNumeric('get'), 10) * parseInt($('#quantity').val(), 10);
						$('#total_hargas').val(total_harga).autoNumeric('init');
						$('input[name="total_harga"]').val(total_harga);
					}
				});

				$('.edit').click(function(){
		          	var id = $(this).attr('penjualanid'); //get the attribute value
		          	$.ajax({
			              url : "<?php echo base_url();?>penjualan/edit",
			              data:{id : id},
			              method:'GET',
			              dataType:'json',
			              success:function(response) {
			                $('input[name="id_penjualan"]').val(response.penjualan.id_penjualan);
			                $('input[name="id_header_penjualan"]').val(response.penjualan.id_header_penjualan);
			                $("#item option[value="+response.penjualan.id_item+"]").attr('selected', 'selected');
			                $("#satuan option[value="+response.penjualan.id_satuan+"]").attr('selected', 'selected');
			                $('input[name="harga_satuan"]').val(response.penjualan.harga_satuan);
			                $('input[name="hargas_satuan"]').val(response.penjualan.harga_satuan);
			                $('input[name="qty"]').val(response.penjualan.qty);
			                $('input[name="ttls_harga"]').val(response.penjualan.total_harga);
			                $('input[name="total_harga"]').val(response.penjualan.total_harga);
			                $('input[name="keterangan"]').val(response.penjualan.keterangan);
			                if(response.design.is_design == 0){
		                		$('.images').css('display', 'none');
			                }else{
			                	$("#my_image").attr("src", "<?php echo base_url();?>gambar/" + response.penjualan.line_item);
			                	$('.images').css('display', 'block');
			                	$('.description').css('display', 'block');
			                }
			                console.log('design: ', response.design.is_design);
			                $('#show_modal').modal({backdrop: 'static', keyboard: true, show: true});
			              }
		        	});
		        });

		        $('.id_item').click(function(){
		        	id = $(this).children("option:selected").val();
		        	$.ajax({
		              url : "<?php echo base_url(); ?>penjualan/getItem",
		              data:{id : id},
		              method:'GET',
		              dataType:'json',
		              success:function(response) {
		                // $(".satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		                $('input[name="satuan"]').val(response.satuan);
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);
		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
		                	$('.description').css('display', 'block');
		                }
		              }
		        	});
		        });

		        item = $('.id_item option:selected').val();
		        if(item != 0){
		        	$.ajax({
		              url : "<?php echo base_url(); ?>penjualan/getItem",
		              data:{id : item},
		              method:'GET',
		              dataType:'json',
		              success:function(response) {
		                // $(".satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		                $('input[name="satuan"]').val(response.satuan);
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);

		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
		                	$('.description').css('display', 'block');
		                }
		              }
		        	});
		        }
				// $('#hrga_satuan').click(function(){
				// 	$('#total_harga').val();
				// 	if($('#qty').val() == ''){
				// 		alert('Harga satuan tidak boleh kosong');
				// 		return false;
				// 	}
				// 	var total_harga = parseInt($('#hrga_satuan').val(), 10) * parseInt($('#qty').val(), 10);
				// 	$('#total_harga').val(total_harga);
				// });
				$('.checkout').click(function(){
					metode_pembayaran = $('.metode_pembayaran option:selected').val();
					if(metode_pembayaran == 0){
						alert('Metode Pembayaran harus dipilih');
						return false;
					}
				})

				$('.discount').keyup(function(){
					grandtotal = $('input[name="total"]').val() - $(this).val();
					$('input[name="grandtotal"]').val(grandtotal);
					$('input[name="discount"]').val($(this).val());
				});

				if($('.discount').val() == 0){
					grandtotal = $('input[name="total"]').val();
					$('input[name="grandtotal"]').val(grandtotal);
				}

				$('#item').change(function(){
				    id = $('#item option:selected').data('id');
		        	$.ajax({
		              url : "<?php echo base_url(); ?>penjualan/getItem",
		              data:{id : id},
		              method:'GET',
		              dataType:'json',
		              success:function(response) {
		                // $("#satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		                $('input[name="satuan"]').val(response.satuan);
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);
		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
		                	$('.description').css('display', 'block');
		                }
		              }
		        	});
				});

		        item = $('#item option:selected').val();
		        if(item != 0){
		        	$.ajax({
		              url : "<?php echo base_url(); ?>penjualan/getItem",
		              data:{id : item},
		              method:'GET',
		              dataType:'json',
		              success:function(response) {
		                // $("#satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		                $('input[name="satuan"]').val(response.satuan);
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);
		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
		                }
		                console.log("design: ",response.is_design);
		              }
		        	});
		        }
			});

		$('.dp1').click(function(){
          	var id = $(this).attr('headerpenjualan'); //get the attribute value
          	$.ajax({
	              url : "<?php echo base_url();?>penjualan/editHeaderPenjualan",
	              data:{id : id},
	              method:'GET',
	              dataType:'json',
	              success:function(response) {
	                $('input[name="grandtotal"]').val(response.header_penjualan.grandtotal);
	                $('input[name="id_header_penjualan"]').val(response.header_penjualan.id_header_penjualan);
	                $('#dp1_modal').modal({backdrop: 'static', keyboard: true, show: true});
	              }
        	});
        });

        $(".submit_dp1").click(function(){
        	if(parseInt($('input[name="dp1"]').val(), 10) > parseInt($('input[name="grandtotal"]').val(), 10)){
        		alert('Jumlah pembayaran untuk DP tidak boleh lebih besar dari grandtotal');
        		return false;
        	}
        });

        $('.dp2').click(function(){
          	var id = $(this).attr('headerpenjualan'); //get the attribute value
          	$.ajax({
	              url : "<?php echo base_url();?>penjualan/editHeaderPenjualan",
	              data:{id : id},
	              method:'GET',
	              dataType:'json',
	              success:function(response) {
	                $('input[name="grandtotal"]').val(response.header_penjualan.grandtotal);
	                $('input[name="id_header_penjualan"]').val(response.header_penjualan.id_header_penjualan);
	                $('input[name="dp1"]').val(response.header_penjualan.dp1);
	                $('input[name="dp"]').val(response.header_penjualan.sisa_pembayaran);
	                $('#dp2_modal').modal({backdrop: 'static', keyboard: true, show: true});
	              }
        	});
        });

        $(".submit_dp2").click(function(){
        	if($('input[name="dp2"]').val() > $('input[name="grandtotal"]').val()){
        		alert('Jumlah pembayaran untuk DP tidak boleh lebih besar dari grandtotal');
        		return false;
        	}
        });

        $('.metode_pembayaran').change(function(){
        	console.log('metode pembayaran:', $('.metode_pembayaran option:selected').val());
        	$('input[name="metode_pembayaran"]').val($('.metode_pembayaran option:selected').val());
        });

  //       $("#tgl_transaksi").datepicker({dateFormat: 'dd-mm-yy'});
		// $('input[name="tgl_penjualan"]').val($("#tgl_transaksi").datepicker());
		$('#tgl_transaksi').datepicker({dateFormat: 'dd-mm-yy',
		    onSelect: function(dateText, inst) {
		      $('input[name="tgl_penjualan"]').val(dateText);
		    }
		});

		$('.harga').autoNumeric('init');
		$('#hrga_satuan').autoNumeric('init');
		</script>
	</body>
</html>
