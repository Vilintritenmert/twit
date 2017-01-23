<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Thujohn\Twitter\Facades\Twitter;
use Carbon\Carbon;

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
            $model->created_at = !empty($fields['id']) ? $fields['created_at'] : '';
            $model->name = !empty($fields['user'])  && !empty($fields['user']['name']) ? $fields['user']['name'] : '';
            $model->screen_name = !empty($fields['user'])  && !empty($fields['user']['screen_name']) ? $fields['user']['screen_name'] : '';
            $model->logo = !empty($fields['user'])  && !empty($fields['user']['profile_image_url']) ? $fields['user']['profile_image_url'] : '';
            $model->media = !empty($fields['extended_entities'])  && !empty($fields['extended_entities']['media']) ? array_shift($fields['extended_entities']['media'])['media_url'] : '';
            $model->text = !empty($fields['text']) ? Twitter::linkify($fields) : '';

            $collection->push($model);
        }

        return $collection;
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
     * Time Ago
     *
     * @return string
     */
    public function getTimeAttribute()
    {
        $time = substr($this->created_at, 0, -10);
        $now = Carbon::now();
        $tweetTime  = Carbon::parse($time);
        return $now->diffForHumans($tweetTime);
    }

    public $timestamps = false;

}
