<?php

class PdfGenerator
{
  public function generate($html,$filename)
  {
    define('DOMPDF_ENABLE_AUTOLOAD', false);
    require_once(dirname(__FILE__) . '/dompdf/dompdf_config.inc.php');
 
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
  }
}