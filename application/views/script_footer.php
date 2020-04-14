
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

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			$(document).ready(function(){
				$('#example').DataTable();

				$('#hrga_satuan').keyup(function(event){
					// console.log(this.value.length);
					$('#total_harga').val('');
					if(this.value.length == 0){
						$(this).val('');
						$('#total_harga').val('');
						alert('Tidak boleh kosonog');
						return false;
					}

					if($('#hrga_satuan').val() != '' && $('#qty').val() != ''){
						var total_harga = parseInt($('#hrga_satuan').val(), 10) * parseInt($('#qty').val(), 10);
						$('#total_harga').val(total_harga);
					}
				});

				$('#qty').keyup(function(){
					$('input[name="total_harga"]').val('');
					if(this.value.length == 0){
						$(this).val('');
						$('#total_harga').val('');
						alert('Tidak boleh kosong');
						return false;
					}
					if($('#hrga_satuan').val() != '' && $('#qty').val() != ''){
						var total_harga = parseInt($('#hrga_satuan').val(), 10) * parseInt($('#qty').val(), 10);
						$('input[name="total_harga"]').val(total_harga);
					}
				});

				$('#harga_satuan').keyup(function(event){
					// console.log(this.value.length);
					$('#total_hargas').val('');
					if(this.value.length == 0){
						$(this).val('');
						$('#total_hargas').val('');
						alert('Tidak boleh kosonog');
						return false;
					}

					if($('#harga_satuan').val() != '' && $('#quantity').val() != ''){
						var total_harga = parseInt($('#harga_satuan').val(), 10) * parseInt($('#quantity').val(), 10);
						$('#total_hargas').val(total_harga);
					}
				});

				$('#quantity').keyup(function(){
					$('#total_hargas').val('');
					if(this.value.length == 0){
						$(this).val('');
						$('#total_hargas').val('');
						alert('Tidak boleh kosong');
						return false;
					}
					if($('#harga_satuan').val() != '' && $('#quantity').val() != ''){
						var total_harga = parseInt($('#harga_satuan').val(), 10) * parseInt($('#quantity').val(), 10);
						$('#total_hargas').val(total_harga);
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
			                $('input[name="qty"]').val(response.penjualan.qty);
			                $('input[name="total_harga"]').val(response.penjualan.total_harga);
			                if(response.penjualan.line_item == ""){
		                		$('.images').css('display', 'none');
			                }else{
			                	$("#my_image").attr("src", "<?php echo base_url();?>gambar/" + response.penjualan.line_item);
			                	$('.images').css('display', 'block');
			                }
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
		                $(".satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);
		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
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
		                $(".satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);
		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
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

				$('#item').click(function(){
		        	id = $(this).children("option:selected").val();
		        	$.ajax({
		              url : "<?php echo base_url(); ?>penjualan/getItem",
		              data:{id : id},
		              method:'GET',
		              dataType:'json',
		              success:function(response) {
		                $("#satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);
		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
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
		                $("#satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);
		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
		                }
		              }
		        	});
		        }
			});
			
		</script>
	</body>
</html>
