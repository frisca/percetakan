<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    function Header(){
        $this->SetY(10);
        // $descrip = "Kamu pun dapat menghitung kata atau huruf sesuai dengan kata atau kalimat tertentu saja di mana kalimat tersebut harus kamu blok atau kamu seleksi terlebih dahulu. Jika tidak ada yang dibloksasaasasas";
        $descrip = "Kamu pun dapat menghitung kata atau huruf sesuai dengan kata atau huruf sesuai dengan kata atau huruf sesuai dengan kata";
        $nama = "Bapak Hendra Kusuma Saassdsdadasqwqqsdsdssdas";
        $tbl = '<table cellspacing="0" cellpadding="2" border="0">
			<tr>
                <td colspan="3" style="font-weight:bold;font-size:16px;">TRISINDO PRINTING</td>
                <td colspan="3" style="top:30px;"></td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:8px;">Setting, Percetakan, Sablon, Dll</td>
                <td colspan="3" border="1">No. Faktur : INV/20/05/0001</td>
			</tr>
			<tr>
                <td colspan="3" style="font-size:9px;">Jl. Kapuk Raya Rt. 011/005 No.1, (Sebelah Gg. Langgar II)</td>
                <td style="font-size:9px;width:55px;">Tgl. Faktur</td>
                <td style="width:19px;text-align:center;">:</td>
                <td style="width:151px;font-size:9px;width:181px;">01 Mei 2020</td>
			</tr>
			<tr>
                <td colspan="3" style="font-size:9px;">Kapuk - Jakarta Barat</td>
                <td style="font-size:9px;width:55px;">Kepada Yth. </td>
                <td style="width:19px;text-align:center;font-size:9px;">:</td>
                <td style="width:151px;font-size:9px;width:181px;">'.$nama.'</td>
			</tr>
            <tr>
                <td colspan="3" style="font-size:9px;">E. trisindoprinting2@gmail.com</td>
                <td></td>
                <td style="width:19px;text-align:center;"></td>
                <td style="width:151px;font-size:9px;text-align:justify;width:181px;" rowspan="2">'.$descrip.'</td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:9px;">T. 0812 9955 9965 / 0812 9395 9695 / 0877 8899 7599</td>
                <td></td>
                <td style="width:19px;text-align:center;"></td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:9px;">Instagram : @trisindoprinting</td>
                <td></td>
                <td style="width:19px;text-align:center;"></td>
                <td style="width:151px;font-size:9px;width:181px;">Telp. 083212311241</td>
			</tr>
		</table>';
        $this->writeHTML($tbl, true, false, false, false, '');
    }

    public function Footer(){
        $this->SetY(-30);
        $tbl = '<table cellspacing="0" cellpadding="2" border="0">
			<tr>
                <td colspan="2">Bank Acc: </td>
                <td style="text-alig:center;">Tanda Terima, </td>
                <td style="text-alig:center;">Hormat Kami, </td>
                <td border="1">Total</td>
                <td border="1">40000</td>
            </tr>
            <tr>
                <td colspan="2">BCA</td>
                <td></td>
                <td></td>
                <td border="1">Disc.</td>
                <td border="1">0</td>
            </tr>
            <tr>
                <td colspan="2">758 0268 611</td>
                <td></td>
                <td></td>
                <td border="1">DP</td>
                <td border="1">2000</td>
            </tr>
            <tr>
                <td colspan="2">An. Stephen Septian</td>
                <td></td>
                <td style="text-alig:center;">(Stephen)</td>
                <td border="1">Sisa</td>
                <td border="1">2000</td>
            </tr>
		</table>';
        $this->writeHTML($tbl, true, false, false, false, '');
    }
}
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */