<?php

namespace App\Http\Controllers;

use App\Events\FetchUrlTitlesEvent;
use App\Events\UrlLookup;
use App\Jobs\UrlLookupJob;
use App\Services\UrlLookupService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function urlLookup(Request $request)
    {
        UrlLookupJob::dispatch($request->get('urls'), Auth::user());
    }

}
