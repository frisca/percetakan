
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

					if($('#hrga_satuan').val() != '' && this.value.length > 0){
						var total_harga = parseInt($('#hrga_satuan').autoNumeric('get'), 10) * parseInt($('#qty').val(), 10);
						$('input[name="total_harga"]').val(total_harga);
						$('input[name="ttl_harga"]').val(total_harga).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
						$('input[name="ttl_harga"]').val(total_harga).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
						// $('input[name="ttl_harga"]').each(function(){
						// 	$('input[name="ttl_harga"]').val(total_harga).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
						// })
					}
				});

				// $('#quantity').keyup(function(){
				// 	$('#total_hargas').val('');
				// 	if(this.value.length == 0){
				// 		$('input[name="ttls_harga"]').val('');
				// 		$('input[name="total_harga"]').val('');
				// 		return false;
				// 	}
				// 	if($('#harga_satuan').val() != '' && $('#quantity').val() != ''){
				// 		var total_harga = parseInt($('#harga_satuan').autoNumeric('get'), 10) * parseInt($('#quantity').val(), 10);
				// 		$('input[name="ttls_harga"]').val(total_harga).autoNumeric('init');
				// 		$('input[name="total_harga"]').val(total_harga);
				// 	}
				// });

				$('#total_hargas').autoNumeric("init");

				$('#quantity').keyup(function(){
					if(this.value.length == 0){
						$('input[name="ttls_harga"]').val('');
						$('input[name="total_harga"]').val('');
					}
					if($('#harga_satuan').val() != '' && $('#quantity').val() != ''){
						console.log('harga: ', $('input[name="harga_satuan"]').val());
						var total_harga = parseInt($('input[name="harga_satuan"]').val(), 10) * parseInt($('#quantity').val(), 10);
						$('input[name="total_harga"]').val(total_harga);
						$('input[name="ttls_harga"]').val(total_harga).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
						$('input[name="ttls_harga"]').val(total_harga).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
					}
				});

				$('.edit').click(function(){
		          	var id = $(this).attr('penjualanid'); //get the attribute value
					$("#item").find('option:selected').removeAttr("selected");
		          	$.ajax({
			              url : "<?php echo base_url();?>penjualan/edit",
			              data:{id : id},
			              method:'GET',
			              dataType:'json',
			              success:function(response) {
							console.log('response: ', response.penjualan.id_item);
							// $('#item option[value='+response.penjualan.id_item+']').attr('selected','selected');
							$("#item").val(response.penjualan.id_item).change();
							// $("#item").selectmenu('refresh', true);
			                $('input[name="id_penjualan"]').val(response.penjualan.id_penjualan);
			                $('input[name="id_header_penjualan"]').val(response.penjualan.id_header_penjualan);
			                $("#item option[value="+response.penjualan.id_item+"]").attr('selected', 'selected');
			                $("#satuan option[value="+response.penjualan.id_satuan+"]").attr('selected', 'selected');
			                $('input[name="harga_satuan"]').val(response.penjualan.harga_satuan.replace('.', ''));
			                $('input[name="hargas_satuan"]').val(response.penjualan.harga_satuan);
							// var harga_satuan = response.penjualan.harga_satuan.split(",");
							// var harga = harga_satuan[0].replace(".", "");
							// $('input[name="harga_satuan"]').val(harga);
			                $('input[name="qty"]').val(response.penjualan.qty);
			                $('input[name="ttls_harga"]').val(response.penjualan.total_harga);
							var total_harga = response.penjualan.total_harga.split(",");
							var total = total_harga[0].replace(".", "");
			                $('input[name="total_harga"]').val(total);
			                $('input[name="keterangan"]').val(response.penjualan.keterangan);
			                if(response.design.is_design == 0){
			                	$("img#my_image").attr("src", "<?php echo base_url();?>gambar/no_img.png");
		                		$('.images').css('display', 'none');
			                }else{
			                	console.log('line item: ', response.penjualan.line_item);
			                	$("img#my_image").attr("src", "<?php echo base_url();?>gambar/" + response.penjualan.line_item);
			                	$('.images').css('display', 'block');
			                	// $('.description').css('display', 'block');
			                }
			                console.log('design: ', response.design.is_design);
			                $('#show_modal').modal({backdrop: 'static', keyboard: true, show: true});
			              }
		        	});
		        });

		        $('.id_item').on('change', function(){
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
		                	// $('.description').css('display', 'block');
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
		                	// $('.description').css('display', 'block');
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
					// grandtotal = $('input[name="total"]').val() - $(this).val();
					// $('input[name="grandtotal"]').val(grandtotal);
					if($('input[name="total"]').val() == 0){
						$('input[name="discounts"]').val($(this).val()).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
						$('input[name="discount"]').val($(this).val().replace('.', ''));
					}else{
						$('input[name="discounts"]').val($(this).val()).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
						$('input[name="discount"]').val($(this).val().replace('.', ''));
						grandtotal = parseInt($('input[name="total"]').val(),10) - parseInt($(this).val().replace('.', ''), 10);
						$('input[name="grandtotal"]').val(grandtotal);
						$('input[name="grandtotals"]').val(grandtotal).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
						$('input[name="grandtotals"]').val(grandtotal).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
					}
				});

				if($('.discount').val() == 0){
					grandtotal = $('input[name="total"]').val();
					$('input[name="grandtotal"]').val(grandtotal);
					$('input[name="grandtotals"]').val(grandtotal).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
					$('input[name="grandtotals"]').val(grandtotal).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
					// grandtotal = $('input[name="total"]').val();
					// $('input[name="grandtotal"]').val(grandtotal);
					// if($('input[name="total"]').val() == 0){
					// 	$('input[name="discounts"]').val($(this).val()).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
					// 	$('input[name="discount"]').val($(this).val().replace('.', ''));
					// }else{
					// 	$('input[name="discounts"]').val($(this).val()).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
					// 	$('input[name="discount"]').val($(this).val().replace(',', ''));
					// 	grandtotal = parseInt($('input[name="total"]').val(),10) - parseInt($(this).val().replace('.', ''), 10);
					// 	$('input[name="grandtotal"]').val(grandtotal);
					// 	$('input[name="grandtotals"]').val(grandtotal).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
					// 	$('input[name="grandtotals"]').val(grandtotal).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
					// }
				}

				$('#item').on('change', function(){
					console.log('test');
					$(this).removeAttr("selected");
					$(this).attr('selected', 'selected');
				    id = $('#item option:selected').data('id');
				    console.log('id: ', id);
				    $.get("<?php echo base_url('penjualan/getItem');?>" + "?id= " + id,function(response){
				    	console.log("response: ", response);
				    	$('input[name="satuan"]').val(response.satuan);
		                $('input[name="id_satuan"]').val(response.id_satuan);
		                // $('input[name="harga_satuan"]').val(response.harga);
		                $('input[name="harga"]').val(response.harga);
						var harga_satuan = response.harga.split(",");
						var harga = harga_satuan[0].replace(".", "");
						console.log("harga : ", harga);
						$('input[name="hargas_satuan"]').val(response.harga);
						$('input[name="harga_satuan"]').val(harga);
						var total = parseInt($('#quantity').val(), 10) * harga;
						$('input[name="total_harga"]').val(total);
						$('input[name="ttls_harga"]').val(total).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
						$('input[name="ttls_harga"]').val(total).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
		                if(response.is_design == 0){
		                	$('.images').css('display', 'none');
		                }else{
		                	$('.images').css('display', 'block');
		                }
				    }, "json");
		    //     	$.ajax({
		    //           url : "<?php echo base_url(); ?>penjualan/getItem",
		    //           data:{id : id},
		    //           method:'GET',
		    //           dataType:'json',
		    //           success:function(response) {
		    //           	console.log('response: ' + response);
		    //             // $("#satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
		    //             $('input[name="satuan"]').val(response.satuan);
		    //             $('input[name="id_satuan"]').val(response.id_satuan);
		    //             // $('input[name="harga_satuan"]').val(response.harga);
		    //             $('input[name="harga"]').val(response.harga);
						// var harga_satuan = response.harga.split(",");
						// var harga = harga_satuan[0].replace(".", "");
						// $('input[name="harga_satuan"]').val(harga);
		    //             if(response.is_design == 0){
		    //             	$('.images').css('display', 'none');
		    //             }else{
		    //             	$('.images').css('display', 'block');
		    //             }
		    //           }
		    //     	});
				});

				// $('.closes').click(function(){
				// 	// $('#item').removeAttr("selected");
				// 	$("#item").find('option:selected').removeAttr("selected");
				// 	$('#show_modal').modal('hide');
				// });

				// $('#show_modal').on('hidden', function () {
				// 	$("#item").find('option:selected').removeAttr("selected");
				// });

				$('.customers').on('change', function(){
					console.log('customer: ', $(this).val());
					var customer = $(this).val();
					$('input[name="customers"]').val(customer);
				});

		        // console.log("items: " + $('#item option:selected').data('id'));
		    //     console.log("items: " + item);
			// items = $('#item option:selected').val();
			// if(items != 0){
			// 	console.log('test1');
			// 	$.ajax({
			// 		url : "<?php echo base_url(); ?>penjualan/getItem",
			// 		data:{id : item},
			// 		method:'GET',
			// 		dataType:'json',
			// 		success:function(response) {
			// 		// $("#satuan option[value="+response.id_satuan+"]").attr('selected', 'selected');
			// 		$('input[name="satuan"]').val(response.satuan);
			// 		$('input[name="id_satuan"]').val(response.id_satuan);
			// 		$('input[name="harga"]').val(response.harga);
			// 		var harga_satuan = response.harga.split(",");
			// 		var harga = harga_satuan[0].replace(".", "");
			// 		$('input[name="harga_satuan"]').val(harga);
			// 		if(response.is_design == 0){
			// 			$('.images').css('display', 'none');
			// 		}else{
			// 			$('.images').css('display', 'block');
			// 		}
			// 		console.log("design: ",response.is_design);
			// 		}
			// 	});
			// }
		});

		$('.dp1').click(function(){
          	var id = $(this).attr('headerpenjualan'); //get the attribute value
          	$.ajax({
	              url : "<?php echo base_url();?>penjualan/editHeaderPenjualan",
	              data:{id : id},
	              method:'GET',
	              dataType:'json',
	              success:function(response) {
	                $('input[name="grandtotals"]').val(response.header_penjualan.grandtotal).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
	                $('input[name="grandtotals"]').val(response.header_penjualan.grandtotal).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
	                $('input[name="grandtotal"]').val(response.header_penjualan.grandtotal);
	                $('input[name="id_header_penjualan"]').val(response.header_penjualan.id_header_penjualan);
	                $('#dp1_modal').modal({backdrop: 'static', keyboard: true, show: true});
	              }
        	});
        });

        $(".submit_dp1").click(function(){
        	if(parseInt($('input[name="dp1"]').val().replace('.', ''), 10) > parseInt($('input[name="grandtotal"]').val().replace('.', ''), 10)){
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
	                $('input[name="grandtotal"]').val(response.header_penjualan.grandtotal).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
	                $('input[name="id_header_penjualan"]').val(response.header_penjualan.id_header_penjualan);
	                $('input[name="dp1"]').val(response.header_penjualan.dp1).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
	                $('input[name="dp"]').val(response.header_penjualan.sisa_pembayaran).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
	                $('#dp2_modal').modal({backdrop: 'static', keyboard: true, show: true});
	              }
        	});
        });

        $(".submit_dp2").click(function(){
        	if(parseInt($('input[name="dp2"]').val().replace('.', ''), 10) > parseInt($('input[name="grandtotal"]').val().replace('.', ''),10)){
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

		// $('.harga_item').keyup(function(){
		// 	grandtotal = $('input[name="total"]').val() + $(this).val();
		// 	$('.harga_item').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
		// 	$('input[name="total"]').val(grandtotal);
		// 	$('input[name="totals"]').val(grandtotal).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
		// });

		$('.harga_item').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
		$('#hrga_satuan').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
		$('#dp1').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});

		$('.harga').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});

		$('.edit_pengeluaran').click(function(){
	      	var id = $(this).attr('pengeluaranid'); //get the attribute value
	      	$.ajax({
              url : "<?php echo base_url();?>pengeluaran/edit",
              data:{id : id},
              method:'GET',
              dataType:'json',
              success:function(response) {
                $('input[name="id_pengeluaran"]').val(response.pengeluaran.id_pengeluaran);
                $('input[name="item"]').val(response.pengeluaran.item);
                $('input[name="keterangan"]').val(response.pengeluaran.keterangan);
                $('input[name="id_header_pengeluaran"]').val(response.pengeluaran.id_header_pengeluaran);
                $('input[name="harga"]').val(response.pengeluaran.price).autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
                $('input[name="harga"]').val(response.pengeluaran.price).autoNumeric('update', {aSep: '.', aDec: ',', mDec: '0'});
                $('#show_modal').modal({backdrop: 'static', keyboard: true, show: true});
              }
	    	});
	    });

	    $('.delete').click(function(){
	      	var id = $(this).attr('deleteid'); //get the attribute value
	      	$('input[name="id"]').val(id);
            $('#delete_modal').modal({backdrop: 'static', keyboard: true, show: true});
		});
		
		$('#from_date').datepicker({dateFormat: 'dd-mm-yy',
		    onSelect: function(dateText, inst) {
		      $('input[name="from_date"]').val(dateText);
		    }
		});

		$('#to_date').datepicker({dateFormat: 'dd-mm-yy',
		    onSelect: function(dateText, inst) {
		      $('input[name="to_date"]').val(dateText);
		    }
		});

		$('.customer').autocomplete({
			source: "<?php echo site_url('report_penjualan/get_autocomplete?');?>",
			// select: function(event, ui) {
			// 	// console.log("ui: " + ui.item.label);
			// 	$('input[name="customers"]').val(ui.item.label);
			// }
			focus: function (event, ui) {
				event.preventDefault();
				$(".customer").val(ui.item.label);
			},
			select: function (event, ui) {
				event.preventDefault();
				$("input[name='customer']").val(ui.item.value);
				$(".customer").val(ui.item.label);
			},
			// close: function(el){
			// 	$("input[name='customer']").attr('value', '');
			// 	$(".customer").val('');
			// }
		});

		$('.csv_penjualan').on('click',function(){
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var no_invoice = $('#no_invoice').val();
			var customer = $('#customer').val();
			var status = $('#status').val();
			var status_pembayaran = $('#status_pembayaran').val();

			// $.ajax({
            //   url : "<?php echo base_url();?>report_penjualan/export",
            //   data:{from_date : from_date, to_date: to_date, no_invoice: no_invoice, customer: customer, status: status, 
			//   status_pembayaran: status_pembayaran},
            //   method:'POST',
            //   dataType:'json',
            //   success:function(response) {
			// 	window.location = "<?php echo base_url('report_penjualan/export');?>" + "?from=" + from_date;
            //   }
	    	// });
			// console.log('status : ' + status + 'status pembayaran : ' + status_pembayaran);
			window.location = "<?php echo base_url('report_penjualan/export');?>" + "?from_date=" + from_date + "&to_date=" + to_date + 
			"&no_invoice=" + no_invoice + "&customer=" + customer + "&invoice=" + status + "&status_pembayaran=" + status_pembayaran;
		});

		$('.csv_pengeluaran').on('click',function(){
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var status = $('#status').val();

			// $.ajax({
            //   url : "<?php echo base_url();?>report_penjualan/export",
            //   data:{from_date : from_date, to_date: to_date, no_invoice: no_invoice, customer: customer, status: status, 
			//   status_pembayaran: status_pembayaran},
            //   method:'POST',
            //   dataType:'json',
            //   success:function(response) {
			// 	window.location = "<?php echo base_url('report_penjualan/export');?>" + "?from=" + from_date;
            //   }
	    	// });
			// console.log('status : ' + status + 'status pembayaran : ' + status_pembayaran);
			window.location = "<?php echo base_url('report_pengeluaran/export');?>" + "?from_date=" + from_date + "&to_date=" + to_date + 
			"&status=" + status;
		});

		$(document).on('hidden', '#show_modal', function () {
			$('#item').removeAttr("selected");
			$(this).remove();
		});

		// $('.closes').click(function(){
		// 	// $('#item').removeAttr("selected");
		// 	$("#item").find('option:selected').removeAttr("selected");
		// 	$('#show_modal').modal('hide');
		// });
		$('#show_modal').on('hidden.bs.modal', function () {
			$("#item").find('option:selected').removeAttr("selected");
		});
		</script>
	</body>
</html>
