<?php

require_once(__DIR__ . '/src/codebird.php');
 		
 		$consumer_key=$_REQUEST['consumer_key'];
 		$consumer_secret=$_REQUEST['consumer_secret'];
 		$token=$_REQUEST['token'];
 		$access_token=$_REQUEST['access_token'];
 		 $file=$_REQUEST['file'];
 		 \Codebird\Codebird::setConsumerKey($consumer_key, $consumer_secret);

         $cb = \Codebird\Codebird::getInstance();

         $cb->setToken($token, $access_token);

           echo $size_bytes = filesize($file);
    	    $fp = fopen($file, 'r');

        $reply = $cb->media_upload([
          'command'     => 'INIT',
          'media_type'  => 'video/mp4',
          'total_bytes' => $size_bytes
        ]);

         echo $media_id = $reply->media_id_string;
 		 

        $segment_id = 0;

        while (! feof($fp)) {
          $chunk = fread($fp, 1048576); // 1MB per chunk for this sample

          $reply = $cb->media_upload([
            'command'       => 'APPEND',
            'media_id'      => $media_id,
            'segment_index' => $segment_id,
            'media'         => $chunk
          ]);

          $segment_id++;
        }

        fclose($fp);

        $reply = $cb->media_upload([
          'command'       => 'FINALIZE',
          'media_id'      => $media_id
        ]);

        if ($reply->httpstatus < 200 || $reply->httpstatus > 299) {
          die();
        }
        else {
            $reply = $cb->statuses_update([
              'status'    => '',
              'media_ids' => $media_id
            ]);
        }

?>