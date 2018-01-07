<?php

/**
 * Created by PhpStorm.
 * User: abdulwahab
 * Date: 06/01/2018
 * Time: 10:15 PM
 */
namespace App\Services;

use \GuzzleHttp\Client;
use Illuminate\Http\Request;

class FacebookAccountService
{

    protected $fbAccountAppId;
    protected $fbAccountAppSecret;
    protected $fbAccountUrl;

    public function __construct(Client $client)
    {
        $this->client   =   $client;
        $this->fbAccountAppId   =   config('fb_account.fb_account_app_id');
        $this->fbAccountAppSecret   =   config('fb_account.fb_account_app_secret');
        $this->fbAccountUrl      = config('fb_account.fb_account_url').config('fb_account.fb_account_api_version');
    }

    public function getAccountUser(Request $request)
    {
        $userAccessToken = $this->getAccessToken($request->get('code'));

        try{
            $request = $this->client->request('GET', $this->fbAccountUrl.'/me?access_token='.$userAccessToken);
        }catch (\Exception $exception){
            throw $exception;
        }

        return json_decode($request->getBody());
    }

    protected function getAccessToken($code)
    {
        $url = $this->fbAccountUrl.'/access_token?grant_type=authorization_code&code='.$code.
            "&access_token=AA|$this->fbAccountAppId|$this->fbAccountAppSecret";

        $apiRequest = $this->client->request('GET', $url);

        $body = json_decode($apiRequest->getBody());

        return $body->access_token;
    }

}