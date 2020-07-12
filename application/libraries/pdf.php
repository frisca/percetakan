<?php
// class pdf {

//     function __construct() {
//         include_once APPPATH . '/third_party/fpdf/fpdf.php';
//     }
// }
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}
?>