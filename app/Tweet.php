<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Thujohn\Twitter\Facades\Twitter;
use View;
use Cache;

class Tweet extends Model
{
    /**
     * Create Collection of Tweet from response
     *
     * @param array $array
     * @return Collection
     */
    public static function createFromTweeter(array $tweets)
    {
        $collection = new Collection;

        foreach($tweets as $fields){

            $model = new Tweet();
            $model->id = !empty($fields['id']) ? $fields['id'] : 0;
            if(!empty($fields['retweeted_status']))
            {
                $model->name = !empty($fields['retweeted_status']['user'])  && !empty($fields['retweeted_status']['user']['name']) ? $fields['retweeted_status']['user']['name'] : '';
                $model->screen_name = !empty($fields['retweeted_status']['user'])  && !empty($fields['retweeted_status']['user']['screen_name']) ? $fields['retweeted_status']['user']['screen_name'] : '';
                $model->logo = !empty($fields['retweeted_status']['user'])  && !empty($fields['retweeted_status']['user']['profile_image_url']) ? $fields['retweeted_status']['user']['profile_image_url'] : '';
            }else{
                $model->name = !empty($fields['user'])  && !empty($fields['user']['name']) ? $fields['user']['name'] : '';
                $model->screen_name = !empty($fields['user'])  && !empty($fields['user']['screen_name']) ? $fields['user']['screen_name'] : '';
                $model->logo = !empty($fields['user'])  && !empty($fields['user']['profile_image_url']) ? $fields['user']['profile_image_url'] : '';
            }

            $model->media = !empty($fields['extended_entities'])  && !empty($fields['extended_entities']['media']) ? array_shift($fields['extended_entities']['media'])['media_url'] : '';
            $model->text = !empty($fields['text']) ? Twitter::linkify($fields) : '';

            $collection->push($model);
        }

        return $collection;
    }

    /**
     * Get Tweets
     *
     * @return array of object
     */
    public static function getTweets()
    {
        if(Cache::has('tweets')){
            $result = Cache::get('tweets');
        }else{
            $tweets = Twitter::getUserTimeline(['screen_name' => 'ukrpravda_news', 'count' => 20, 'format' => 'array']);
            $tweetsCollections = Tweet::createFromTweeter($tweets);
            $result = Tweet::getObjects($tweetsCollections);
            Cache::put('tweets', $result, 1);
        }

        return $result;
    }

    /**
     * Retweeted
     *
     * @return mixed
     */
    public function getRetweetedAttribute()
    {
        return  $this->name !== 'Українська правда' ? '<small><i>Українська правда ретвітнув(ла)</i></small>' : '';
    }

    /**
     * Adapt to ID and View field;
     *
     * @param $collections
     */
    public static function getObjects(Collection &$collections)
    {
        $result = [];

        foreach($collections as $item)
        {
            $result[] = (object)['id'=>$item->id, 'view'=>str_replace(['\''],'',$item->view)];
        }

        return $result;
    }

    /**
     * Get Image
     *
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->media ? '<img src="'.$this->media.'">' : '';
    }


    /**
     * Generate View for tweet
     */
    public function getViewAttribute()
    {
        return View::make('twitter.tweet', ['tweet'=>$this])->render();
    }





    public $timestamps = false;

}
