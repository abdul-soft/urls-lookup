<?php
/**
 * Created by PhpStorm.
 * User: abdulwahab
 * Date: 07/01/2018
 * Time: 4:04 AM
 */

namespace App\Services;


use App\Events\UrlLookup;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class UrlLookupService
{

    protected $client;
    protected $user;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function lookup($urls, User $user)
    {
        $this->user = $user;
        $urls = explode(',', $urls);

        $requests = function($urls) {

            foreach ($urls as $url) {
                yield new Request('GET', trim($url));
            }
        };

        $pool = new Pool($this->client, $requests($urls), [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index) {

                $str = $response->getBody()->getContents();

                if(strlen($str)>0){

                    $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>

                    preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case

                    broadcast(new UrlLookup($this->user, $title[1], $index));
                }
                // this is delivered each successful response
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
                \Log::info($reason);

            },
        ]);


        $promise = $pool->promise();
        $promise->wait();
    }

}