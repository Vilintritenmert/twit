<?php

namespace App\Http\Controllers;

use View;
use Twitter;
use App\Tweet;

class TwitterController extends Controller
{
    /**
     * Show Main page
     */
    public function index()
    {
        $tweets = Twitter::getUserTimeline(['screen_name' => 'ukrpravda_news', 'count' => 20, 'format' => 'array']);
        $tweetsCollections = Tweet::createFromTweeter($tweets);

        return \View::make('twitter.index', ['tweets'=>$tweetsCollections]);
    }

    /**
     * List Of tweets
     */
    public function listAjax()
    {

    }
}
