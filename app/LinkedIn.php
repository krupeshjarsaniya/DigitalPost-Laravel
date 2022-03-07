<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use File;


class LinkedIn
{
    private $redirect_uri;
    private $client_id;
    private $client_secret;

    public function __construct()
    {
        $config = config('services.linkedin');
        $this->redirect_uri = $config['linkedin_url'];
        $this->client_id = $config['linkedin_client_id'];
        $this->client_secret = $config['linkedin_client_secret'];
    }
    public static function getAccessToken($code)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://www.linkedin.com/oauth/v2/accessToken', [
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'code'          => $code,
                'redirect_uri'  => $this->redirect_uri,
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'scope' => 'rw_ads,r_basicprofile,w_organization_social,w_member_social,rw_organization_admin',
            ],
        ]);

        $object = json_decode($response->getBody()->getContents(), true);
        $access_token = $object['access_token'];
        log::info('---acess-token---' . $access_token);
        return $access_token;
    }

    public static function getProfile($access_token)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.linkedin.com/v2/me?projection=(id,localizedFirstName,localizedLastName,profilePicture(displayImage~digitalmediaAsset:playableStreams))', [
            'headers' => [
                'Authorization' => 'Bearer '.$access_token,
                'Connection'    => 'Keep-Alive',
            ],
        ]);
        $object = json_decode($response->getBody()->getContents(), true);

        return $object;
    }

    public static function getUserPages($access_token)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.linkedin.com/v2/organizationAcls?q=roleAssignee', [
            'headers' => [
                'Authorization' => 'Bearer '.$access_token,
                'Connection'    => 'Keep-Alive',
                'X-Restli-Protocol-Version' => '2.0.0'
            ],
        ]);
        $object = json_decode($response->getBody()->getContents(), true);

        return $object;
    }

    public static function getPage($access_token, $id)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.linkedin.com/v2/organizations/'.$id.'?projection=(coverPhotoV2(original~:playableStreams,cropped~:playableStreams,cropInfo),logoV2(original~:playableStreams,cropped~:playableStreams,cropInfo))', [
            'headers' => [
                'Authorization' => 'Bearer '.$access_token,
                'Connection'    => 'Keep-Alive',
                'X-Restli-Protocol-Version' => '2.0.0'
            ],
        ]);
        $object = json_decode($response->getBody()->getContents(), true);

        return $object;
    }

    public static function getPageList($access_token, $ids)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.linkedin.com/v2/organizations?ids=List('.implode(',', $ids).')', [
            'headers' => [
                'Authorization' => 'Bearer '.$access_token,
                'Connection'    => 'Keep-Alive',
                'X-Restli-Protocol-Version' => '2.0.0'
            ],
        ]);
        $object = json_decode($response->getBody()->getContents(), true);

        return $object;
    }

    private static function registerUpload($access_token, $personURN)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://api.linkedin.com/v2/assets?action=registerUpload', [
            'headers' => [
                'Authorization' => 'Bearer '.$access_token,
                'Connection'    => 'Keep-Alive',
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'registerUploadRequest' => [
                    'recipes' => [
                        'urn:li:digitalmediaRecipe:feedshare-image',
                    ],
                    'owner'                => 'urn:li:person:'.$personURN,
                    'serviceRelationships' => [
                        [
                            'relationshipType' => 'OWNER',
                            'identifier'       => 'urn:li:userGeneratedContent',
                        ],
                    ],
                ],
            ],
        ]);
        $object = json_decode($response->getBody()->getContents(), true);

        return $object;
    }

    private static function registerUploadPage($access_token, $personURN)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://api.linkedin.com/v2/assets?action=registerUpload', [
            'headers' => [
                'Authorization' => 'Bearer '.$access_token,
                'Connection'    => 'Keep-Alive',
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'registerUploadRequest' => [
                    'recipes' => [
                        'urn:li:digitalmediaRecipe:feedshare-image',
                    ],
                    'owner'                => 'urn:li:organization:'.$personURN,
                    'serviceRelationships' => [
                        [
                            'relationshipType' => 'OWNER',
                            'identifier'       => 'urn:li:userGeneratedContent',
                        ],
                    ],
                    'supportedUploadMechanism'=>[
                        'SYNCHRONOUS_UPLOAD'
                    ],
                ],
            ],
        ]);
        $object = json_decode($response->getBody()->getContents(), true);

        return $object;
    }

    private static function registerVideoUpload($access_token, $personURN)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://api.linkedin.com/v2/assets?action=registerUpload', [
            'headers' => [
                'Authorization' => 'Bearer '.$access_token,
                'Connection'    => 'Keep-Alive',
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'registerUploadRequest' => [
                    'recipes' => [
                        'urn:li:digitalmediaRecipe:feedshare-video',
                    ],
                    'owner'=> 'urn:li:person:'.$personURN,
                    'serviceRelationships' => [
                        [
                            'relationshipType' => 'OWNER',
                            'identifier'       => 'urn:li:userGeneratedContent',
                        ],
                    ],
                ],
            ],
        ]);
        $object = json_decode($response->getBody()->getContents(), true);
        //$asset = $object['value']['asset'];
        //$asset_array=explode(':', $asset);
        //Log::info('==asset id======='.$asset_array[3]);
        return $object;
    }

    private static function registerVideoUploadPage($access_token, $personURN)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://api.linkedin.com/v2/assets?action=registerUpload', [
            'headers' => [
                'Authorization' => 'Bearer '.$access_token,
                'Connection'    => 'Keep-Alive',
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'registerUploadRequest' => [
                    'recipes' => [
                        'urn:li:digitalmediaRecipe:feedshare-video',
                    ],
                    'owner'=> 'urn:li:organization:'.$personURN,
                    'serviceRelationships' => [
                        [
                            'relationshipType' => 'OWNER',
                            'identifier'       => 'urn:li:userGeneratedContent',
                        ],
                    ],
                ],
            ],
        ]);
        $object = json_decode($response->getBody()->getContents(), true);
        //$asset = $object['value']['asset'];
        //$asset_array=explode(':', $asset);
        //Log::info('==asset id======='.$asset_array[3]);
        return $object;
    }

    private static function uploadImage($url, $access_token, $image)
    {
        $client = new Client();
       
           $client->request('PUT', $url, [
                    'headers' => [
                        'Authorization' => 'Bearer '.$access_token,
                    ],
                    'body' => fopen($image, 'r'),

                ]
            );
    }

    private static function uploadVideo($url, $access_token, $image)
    {
        $client = new Client();
            
            $file=file_get_contents($image);
            $client->request('PUT', $url, [
                    'headers' => [
                        'Authorization' => 'Bearer '.$access_token,
                    ],
                    'body' => $file,
                    //'body' => fopen($image, 'r'),
                ]
            );
    }

    public static function shareImage($code, $image, $text, $access_type = 'code')
    {
        $client = new Client();
        $access_token = ($access_type === 'code') ? self::getAccessToken($code) : $code;
        $personURN = self::getProfile($access_token)['id'];
        $uploadObject = self::registerUpload($access_token, $personURN);
        $asset = $uploadObject['value']['asset'];
        $uploadUrl = $uploadObject['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'];
        self::uploadImage($uploadUrl, $access_token, $image);
         Log::info('--------------------image--------------------');

           Log::info($uploadUrl);
           Log::info('asset ----'.$asset);
        $client->request('POST', 'https://api.linkedin.com/v2/ugcPosts', [
            'headers' => [
                'Authorization'             => 'Bearer '.$access_token,
                'Connection'                => 'Keep-Alive',
                'Content-Type'              => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0',
            ],
            'json' => [
                'author'          => 'urn:li:person:'.$personURN,
                'lifecycleState'  => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $text,
                        ],
                        'shareMediaCategory' => 'IMAGE',
                        'media'              => [
                            [
                                'status' => 'READY',
                                //'originalUrl' => 'https://linkedin.com/',
                                'media' => $asset,

                            ],
                        ],
                    ],
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                ],
            ],
        ]);
        Log::info('--------------------image--------------------');

    }

    public static function shareImagePage($code, $image, $text, $access_type = 'code', $page_id)
    {
        $client = new Client();
        $access_token = ($access_type === 'code') ? self::getAccessToken($code) : $code;
        $personURN = $page_id;
        $uploadObject = self::registerUploadPage($access_token, $personURN);
        $asset = $uploadObject['value']['asset'];
        $uploadUrl = $uploadObject['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'];
        self::uploadImage($uploadUrl, $access_token, $image);
         Log::info('--------------------image--------------------');

           Log::info($uploadUrl);
           Log::info('asset ----'.$asset);
        $client->request('POST', 'https://api.linkedin.com/v2/shares', [
            'headers' => [
                'Authorization'             => 'Bearer '.$access_token,
                'Connection'                => 'Keep-Alive',
                'Content-Type'              => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0',
            ],
            'json' => [
                'owner'          => 'urn:li:organization:'.$personURN,
                'subject'  => $text,
                'text' => [
                    'text' => $text,
                ],
                'distribution' => [
                    'linkedInDistributionTarget' => [
                        'visibleToGuest' => true,
                    ],
                ],
                'content' => [
                    'contentEntities'=> [
                        [
                            'entity'=> $asset
                        ]
                    ],
                    'title'=> $text,
                    'shareMediaCategory'=> 'IMAGE'
                ],
            ],
        ]);
        Log::info('--------------------image--------------------');

    }

    public static function shareVideo($code, $image, $text, $access_type = 'code')
    {
        $client = new Client();
        $access_token = ($access_type === 'code') ? self::getAccessToken($code) : $code;
        $personURN = self::getProfile($access_token)['id'];
        $uploadObject = self::registerVideoUpload($access_token, $personURN);
        $asset = $uploadObject['value']['asset'];
        $uploadUrl = $uploadObject['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'];
         Log::info('--------------------video--------------------');
         Log::info($uploadUrl);
           Log::info('access_token ----'.$access_token);
           Log::info('asset ----'.$asset);
           Log::info('uploadUrl ----'.$uploadUrl);
           Log::info('video url-----'.$image);

        $abc=self::uploadVideo($uploadUrl, $access_token, $image);
        $a=$client->request('POST', 'https://api.linkedin.com/v2/ugcPosts', [
            'headers' => [
                'Authorization'             => 'Bearer '.$access_token,
                'Connection'                => 'Keep-Alive',
                'Content-Type'              => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0',
            ],
            'json' => [
                'author'          => 'urn:li:person:'.$personURN,
                'lifecycleState'  => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $text,
                        ],
                        'shareMediaCategory' => 'VIDEO',
                        'media'              => [
                            [
                                'status' => 'READY',
                                'media' => $asset,

                            ],
                        ],
                    ],
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                ],
            ],
        ]);
         
          $object = json_decode($a->getBody(), true);//$response->getStatusCode()
          //$object = json_decode($a->getStatusCode(), true);//$response->getStatusCode()

         Log::info($object);
         $video_post_id=$object['id'];

         Log::info('--------------------video--------------------');

    }

    public static function shareVideoPage($code, $image, $text, $access_type = 'code', $page_id)
    {
        $client = new Client();
        $access_token = ($access_type === 'code') ? self::getAccessToken($code) : $code;
        $personURN = $page_id;
        $uploadObject = self::registerVideoUploadPage($access_token, $personURN);
        $asset = $uploadObject['value']['asset'];
        $uploadUrl = $uploadObject['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'];
         Log::info('--------------------video--------------------');
         Log::info($uploadUrl);
           Log::info('access_token ----'.$access_token);
           Log::info('asset ----'.$asset);
           Log::info('uploadUrl ----'.$uploadUrl);
           Log::info('video url-----'.$image);

        $abc=self::uploadVideo($uploadUrl, $access_token, $image);
        $a=$client->request('POST', 'https://api.linkedin.com/v2/ugcPosts', [
            'headers' => [
                'Authorization'             => 'Bearer '.$access_token,
                'Connection'                => 'Keep-Alive',
                'Content-Type'              => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0',
            ],
            'json' => [
                'author'          => 'urn:li:organization:'.$personURN,
                'lifecycleState'  => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $text,
                            'attributes' => [],
                        ],
                        'shareMediaCategory' => 'VIDEO',
                        'media'              => [
                            [
                                'status' => 'READY',
                                'media' => $asset,
                                'title' => [
                                    'attributes' => [],
                                    'text' => $text,
                                ],
                            ],
                        ],
                    ],
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                ],
                // 'targetAudience' => [],
            ],
        ]);
         
          $object = json_decode($a->getBody(), true);//$response->getStatusCode()
          //$object = json_decode($a->getStatusCode(), true);//$response->getStatusCode()

         Log::info($object);
         $video_post_id=$object['id'];

         Log::info('--------------------video--------------------');

    }
    

    public static function shareArticle($code, $url, $text, $access_type = 'code')
    {
        $client = new Client();
        $access_token = ($access_type === 'code') ? self::getAccessToken($code) : $code;
        $personURN = self::getProfile($access_token)['id'];

        $client->request('POST', 'https://api.linkedin.com/v2/ugcPosts', [
            'headers' => [
                'Authorization'             => 'Bearer '.$access_token,
                'Connection'                => 'Keep-Alive',
                'Content-Type'              => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0',
            ],
            'json' => [
                'author'          => 'urn:li:person:'.$personURN,
                'lifecycleState'  => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $text,
                        ],
                        'shareMediaCategory' => 'ARTICLE',
                        'media'              => [
                            [
                                'status'      => 'READY',
                                'originalUrl' => $url,

                            ],
                        ],
                    ],
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                ],
            ],
        ]);
    }

    public static function shareNone($code, $text, $access_type = 'code')
    {
        $client = new Client();
        $access_token = ($access_type === 'code') ? self::getAccessToken($code) : $code;
        $personURN = self::getProfile($access_token)['id'];

        $client->request('POST', 'https://api.linkedin.com/v2/ugcPosts', [
            'headers' => [
                'Authorization'             => 'Bearer '.$access_token,
                'Connection'                => 'Keep-Alive',
                'Content-Type'              => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0',
            ],
            'json' => [
                'author'          => 'urn:li:person:'.$personURN,
                'lifecycleState'  => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $text,
                        ],
                        'shareMediaCategory' => 'NONE',
                    ],
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                ],
            ],
        ]);
    }
}