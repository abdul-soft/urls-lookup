<?php
/**
 * Created by PhpStorm.
 * User: abdulwahab
 * Date: 07/01/2018
 * Time: 4:04 AM
 */

namespace App\Services;


use GuzzleHttp\Client;

class UrlLookupService
{

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function lookup($url)
    {
        $data = $this->client->request('GET', trim($url));

        $str = $data->getBody()->getContents();

        if(strlen($str)>0){

            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>

            preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case

            return $title[1];
        }
        return 'No Title Found';
    }

}