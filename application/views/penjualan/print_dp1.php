<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Test</title>
    <style>
        table .header_dp1 {
            border-collapse: collapse;
            page-break-inside:auto 
        }
        tr    { 
            page-break-inside:avoid; 
            page-break-after:auto 
        }
        thead { 
            display:table-header-group 
        }
        .header_dp1 th.header, td.header {
            /* border: black 1px solid; */
            text-align: justify;
            padding-left: 5px;
            padding-right: 5px;
            min-width: 700px;
        }
        th.header {
            font-size: 20px;
        }
        @page {
            size: legal portrait;
            margin: 1cm;

        }

        table .item {
            border-collapse: collapse;
            page-break-inside:auto 
        }

        .item td {
            border: black 1px solid;
            text-align: justify;
            padding-left: 5px;
            padding-right: 5px;
        }

        .item td.no {
            min-width: 10px;
        }

        .item td.nama {
            min-width: 450px;
        }

        .item td.qty {
            min-width: 100px;
        }

        .item td.harga {
            min-width: 255px;
        }

        .item td.jumlah {
            min-width: 190px;
        }
    </style>
</head>
<body>
    <table class="header_dp1">
        <tr>
            <th class="header">
                TRISINDO PRINTING
            </th>
            <th class="header">
                No.Faktur: INV/20/05/00001
            </th>
        </tr>
        <tr>
            <td class="header">Setting, Percetakan, Sablon, Dll</td>
            <td class="header"></td>
        </tr>
        <tr>
            <td class="header">Jl. Kapuk Raya RT. 011/005 NO. 1 (Sebelah Gg. Langgar II)</td>
            <td class="header">Tgl Faktur &nbsp; : </td>
        </tr>
        <tr>
            <td class="header">Kapuk Jakarta Barat</td>
            <td class="header">Kepada Yth : Bapak</td>
        </tr>
        <tr>
            <td class="header">E. trisindoprinting@gmail.com</td>
            <td class="header">
                <div style="margin-left:89px;">PT ABCDPT - Kapuk</div>
            </td>
        </tr>
        <tr>
            <td class="header">0812 9965 / 0812 9395 9695 / 0877 8899 7599</td>
            <td class="header">
                <div style="margin-left:89px;">Telp. 0812</div>
            </td>
        </tr>
        <tr>
            <td class="header">Instagram: @trisindoprinting</td>
            <td class="header"></td>
        </tr>
    </table>
    <br>
    <table class="item">
        <tr>
            <td class="no">No</td>
            <td class="nama">Nama Barang</td>
            <td class="qty">Qty</td>
            <td class="harga">Harga Satuan</td>
            <td class="jumlah">Jumlah</td>
        </tr>
        <tr>
            
        </tr>
        <!-- <tr>
            <td class="no">No</td>
            <td>Nama Barang</td>
            <td>Qty</td>
            <td>Harga Satuan</td>
            <td>Jumlah</td>
        </tr>
        <tr>
            <td class="no">No</td>
            <td>Nama Barang</td>
            <td>Qty</td>
            <td>Harga Satuan</td>
            <td>Jumlah</td>
        </tr> -->
    </table>

    <script>
		window.print();
	</script>
</body>
</html>
