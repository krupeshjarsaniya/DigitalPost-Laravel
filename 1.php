<?php

$row = 1;
if (($handle = fopen("business.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
    //echo "<p> $num fields in line $row: <br /></p>\n";
    $row++;
    /*for ($c=0; $c < $num; $c++) {
        //echo $data[$c] . "<br />\n";


    }*/
    echo $data[8].'<br>';
    if(!empty($data[8]))
    {
    $dd=explode('/', $data[8]);
    $filename= 'public/images/'.end($dd);
    //chown($filename,465);
    if (file_exists($filename)) {
	   unlink($filename);
	    echo 'File '.$filename.' has been deleted<br>';
	  } else {
	    //echo 'Could not delete '.$filename.', file does not exist<br>';
	  }

        //echo $data[8] . "<br />\n";
	}
	else
	{
		echo '============================<br>';
	}
  }
  fclose($handle);
}
?>