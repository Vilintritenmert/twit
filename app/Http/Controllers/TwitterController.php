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
        $tweetsCollections = Tweet::getTweets();

        return \View::make('twitter.index', ['tweets'=>$tweetsCollections]);
    }

    /**
     * List Of tweets
     */
    public function tweetList()
    {
        $tweets = Tweet::getTweets();

        return response()->json($tweets);

    }
}
