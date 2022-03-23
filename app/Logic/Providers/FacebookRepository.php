<?php

namespace App\Logic\Providers;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Log;
use Facebook\Facebook;

class FacebookRepository
{
    protected $facebook;

    public function __construct()
    {
        $config = config('services.facebook');
        $this->facebook = new Facebook([
            'app_id' => $config['client_id'],
            'app_secret' => $config['client_secret'],
            'default_graph_version' => 'v11.0',
        ]);
    }

    public function redirectTo()
    {
        $helper = $this->facebook->getRedirectLoginHelper();

        $permissions = [
            'pages_show_list',
            'pages_read_engagement',
            'publish_video',
        ];
        $redirectUri = config('app.url') . 'facebook/callback';

        return $helper->getLoginUrl($redirectUri, $permissions);
    }

    public function redirectToInsta()
    {
        $helper = $this->facebook->getRedirectLoginHelper();

        $permissions = [
            'instagram_basic',
            'pages_show_list',
            'pages_read_engagement',
            'publish_video',
            'instagram_content_publish'
        ];
        $redirectUri = config('app.url') . 'facebook/callback';

        return $helper->getLoginUrl($redirectUri, $permissions);
    }

    public function getProfileByAccessToken($accessToken)
    {
        $data = $this->facebook->get('/me?fields=id,name,email,picture', $accessToken);
        return $data->getGraphNode()->asArray();
    }

    public function handleCallback()
    {
        $helper = $this->facebook->getRedirectLoginHelper();

        if (request('state')) {
            $helper->getPersistentDataHandler()->set('state', request('state'));
        }
       // dd($helper);
        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            throw new Exception("Graph returned an error: {$e->getMessage()}");
        } catch(FacebookSDKException $e) {
            throw new Exception("Facebook SDK returned an error: {$e->getMessage()}");
        }

        if (!isset($accessToken)) {
            throw new Exception('Access token error');
        }

        if (!$accessToken->isLongLived()) {
            try {
                $oAuth2Client = $this->facebook->getOAuth2Client();
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
                throw new Exception("Error getting a long-lived access token: {$e->getMessage()}");
            }
        }

        return $accessToken->getValue();

        //store acceess token in databese and use it to get pages
    }

    public function getPages($accessToken)
    {
        $pages = $this->facebook->get('/me/accounts', $accessToken);
        $pages = $pages->getGraphEdge()->asArray();

        return array_map(function ($item) {
            return [
                'access_token' => $item['access_token'],
                'id' => $item['id'],
                'name' => $item['name'],
                'image' => "https://graph.facebook.com/{$item['id']}/picture?type=large"
            ];
        }, $pages);
    }

    public function post($accountId, $accessToken, $content, $images = [])
    {
      $data = ['message' => $content];

      $attachments = $this->uploadImages($accountId, $accessToken, $images);

      foreach ($attachments as $i => $attachment) {
          $data["attached_media[$i]"] = "{\"media_fbid\":\"$attachment\"}";
      }

      try {
          return $this->postData($accessToken, "$accountId/feed", $data);
      } catch (\Exception $exception) {
          //notify user about error
          return false;
      }
    }

    public function uploadImages($accountId, $accessToken, $caption, $images = [])
    {
        $attachments = [];

        foreach ($images as $image) {
            if (!file_exists($image)) continue;

            $data = [
                'message' => $caption,
                'source' => $this->facebook->fileToUpload($image),
            ];

            try {
                $response = $this->postData($accessToken, "$accountId/photos?published=true", $data);
                if ($response) $attachments[] = $response['id'];
            } catch (\Exception $exception) {
                // throw new Exception("Error while posting: {$exception->getMessage()}", $exception->getCode());
            }
            break;
        }

        return $attachments;
    }

    public function uploadVideos($accountId, $accessToken, $caption, $images = [])
    {
        $attachments = [];

        foreach ($images as $image) {
            if (!file_exists($image)) continue;

            $destinationPath = 'uploads';
            $image->move($destinationPath,$image->getClientOriginalName());
            $path = url('uploads/' . $image->getClientOriginalName());

            $data = [
                'message' => $caption,
                'file_url' => $path,
            ];

            try {
                $response = $this->postData($accessToken, "$accountId/videos?published=true", $data);
                if ($response) $attachments[] = $response['id'];
            } catch (\Exception $exception) {
                throw new Exception("Error while posting: {$exception->getMessage()}", $exception->getCode());
            }
            break;
        }

        return $attachments;
    }

    public function uploadImageProfile($accessToken, $caption, $images = [])
    {
        $attachments = [];

        foreach ($images as $image) {
            if (!file_exists($image)) continue;
            $destinationPath = 'uploads';
            $image->move($destinationPath,$image->getClientOriginalName());
            $path = url('uploads/' . $image->getClientOriginalName());
            $data = [
                'message' => $caption,
                'url' => $this->facebook->fileToUpload($path),
            ];
            // dd($data);

            try {
                $response = $this->postData($accessToken, "me/feed", $data);
                if ($response) $attachments[] = $response['id'];
            } catch (\Exception $exception) {
                throw new Exception("Error while posting: {$exception->getMessage()}", $exception->getCode());
            }
        }

        return $attachments;
    }

    public function uploadVideosProfile($accessToken, $caption, $videos = [])
    {
        $attachments = [];

        foreach ($videos as $video) {
            if (!file_exists($video)) continue;
            $destinationPath = 'uploads';
            $video->move($destinationPath,$video->getClientOriginalName());
            $path = url('uploads/' . $video->getClientOriginalName());
            $data = [
                'message' => $caption,
                'source' => $this->facebook->fileToUpload($path),
            ];

            try {
                $response = $this->postData($accessToken, "me/videos", $data);
                if ($response) $attachments[] = $response['id'];
            } catch (\Exception $exception) {
                throw new Exception("Error while posting: {$exception->getMessage()}", $exception->getCode());
            }
        }

        return $attachments;
    }

    private function postData($accessToken, $endpoint, $data)
    {
        try {
            $response = $this->facebook->post(
                $endpoint,
                $data,
                $accessToken
            );
            return $response->getGraphNode();

        } catch (FacebookResponseException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        } catch (FacebookSDKException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }


    public function InstaPostData($accessToken, $endpoint, $data)
    {
        try {
            $response = $this->facebook->post(
                $endpoint,
                $data,
                $accessToken
            );
            return $response->getGraphNode();

        } catch (FacebookResponseException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        } catch (FacebookSDKException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function InstaGetData($accessToken,$endpoint)
    {
        $pages = $this->facebook->get($endpoint, $accessToken);
        $pages = $pages->getGraphNode()->asArray();
        return $pages;
    }

    public function getInstaBusinessAccountId($pageId,$accessToken)
    {
        $pages = $this->facebook->get($pageId."?fields=instagram_business_account",$accessToken);
        $pages = $pages->getGraphNode()->asArray();
        return $pages;
        // dd($pages);
        return array_map(function ($item) {
            return [
                'access_token' => $item['access_token'],
                'id' => $item['id'],
                'name' => $item['name'],
                'image' => "https://graph.facebook.com/{$item['id']}/picture?type=large"
            ];
        }, $pages);
    }

}
