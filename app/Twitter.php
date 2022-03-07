<?php

namespace App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;


class Twitter
{
  public static function getProfile($token, $access_token) {
    require_once(__DIR__ . '/codebird-php-develop/src/codebird.php');
      $config = config('services.twitter');
      $consumer_key = $config['consumer_key'];
      $consumer_secret = $config['consumer_secret'];
      \Codebird\Codebird::setConsumerKey($consumer_key, $consumer_secret);

      $cb = \Codebird\Codebird::getInstance();

      $cb->setToken($token, $access_token);
      return $cb->account_verifyCredentials();
  }
  public static function shareImage($token, $access_token, $file, $caption) {
      require_once(__DIR__ . '/codebird-php-develop/src/codebird.php');
      $config = config('services.twitter');
      $consumer_key = $config['consumer_key'];
      $consumer_secret = $config['consumer_secret'];
      \Codebird\Codebird::setConsumerKey($consumer_key, $consumer_secret);

      $cb = \Codebird\Codebird::getInstance();

      $cb->setToken($token, $access_token);

      $reply = $cb->media_upload(array(
        'media' => $file
      ));

      $result = $cb->statuses_update([
        'status' => $caption,
        'media_ids' => $reply->media_id_string
      ]);
  }

  public static function shareVideo($token, $access_token, $file, $caption) {
      require_once(__DIR__ . '/codebird-php-develop/src/codebird.php');
      $config = config('services.twitter');
      $consumer_key = $config['consumer_key'];
      $consumer_secret = $config['consumer_secret'];
      
      // Log::info('consumer_key'.$consumer_key);
      // Log::info('consumer_secret'.$consumer_secret);
      // Log::info('token'.$token);
      // Log::info('access_token'.$access_token);
      // Log::info('file'.$file);

      \Codebird\Codebird::setConsumerKey($consumer_key, $consumer_secret);
      $cb = \Codebird\Codebird::getInstance();

      $cb->setToken($token, $access_token);

      // $size_bytes = Storage::size('/storage/schedule-post-video/2022/01/Nvo1ZS8DfOXEI90GcTX7ky9LyPUpC4QrWiVekq9K.mp4');
      // $fp = file_get_contents(Storage::url('/storage/schedule-post-video/2022/01/Nvo1ZS8DfOXEI90GcTX7ky9LyPUpC4QrWiVekq9K.mp4'));

       $size_bytes = Storage::size($file);
      $fp = file_get_contents(Storage::url($file));


      $reply = $cb->media_upload([
        'command'     => 'INIT',
        'media_type'  => 'video/mp4',
        'total_bytes' => $size_bytes
      ]);

      $media_id = $reply->media_id_string;

      $segment_id = 0;
      
      $reply = $cb->media_upload([
          'command'       => 'APPEND',
          'media_id'      => $media_id,
          'segment_index' => $segment_id,
          'media'         => $fp
        ]);

      $reply = $cb->media_upload([
        'command'       => 'FINALIZE',
        'media_id'      => $media_id
      ]);


        $reply = $cb->statuses_update([
            'status'    => $caption,
            'media_ids' => $media_id
          ]);
        $r=json_encode($reply);
      Log::info('----------------'.$r);

       //=================================================== 
      // while (! feof($fp)) {
      //   $chunk = fread($fp, 1048576); // 1MB per chunk for this sample

      //   $reply = $cb->media_upload([
      //     'command'       => 'APPEND',
      //     'media_id'      => $media_id,
      //     'segment_index' => $segment_id,
      //     'media'         => $chunk
      //   ]);

      //   $segment_id++;
      // }

      // fclose($fp);

      // $reply = $cb->media_upload([
      //   'command'       => 'FINALIZE',
      //   'media_id'      => $media_id
      // ]);

      // if ($reply->httpstatus < 200 || $reply->httpstatus > 299) {
      //   die();
      // }
      // else {
      //     $reply = $cb->statuses_update([
      //       'status'    => '',
      //       'media_ids' => $media_id
      //     ]);
      // }
  }
}