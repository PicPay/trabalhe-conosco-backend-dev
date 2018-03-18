<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel, charset=utf-8");
header ("Content-Disposition: attachment; filename=\"Report.xls" );
header ("Content-Description: Generated Report" );
?>
<?php echo $content_for_layout ?> 