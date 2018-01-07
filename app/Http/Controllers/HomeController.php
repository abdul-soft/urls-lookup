<?php

namespace App\Http\Controllers;

use App\Events\UrlLookup;
use App\Services\UrlLookupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    protected $lookupService;
    /**
     * Create a new controller instance.
     *
     * @param UrlLookupService $lookupService
     * @return void
     */
    public function __construct(UrlLookupService $lookupService)
    {
        $this->middleware('auth');
        $this->lookupService = $lookupService;
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
        $urls = $request->get('urls');

        foreach(explode(',', $urls) as $url){

            $title = $this->lookupService->lookup($url);

            broadcast(new UrlLookup(Auth::user(), $title));
        }


    }
}
