<div class="tweet" data-id="{{$tweet->id}}">{!! $tweet->retweeted!!}<div class="header"><div class="logo"><img src="{{$tweet->logo}}"></div><div class="name"><b>{{$tweet->name}}</b></div><div class="login">{{'@'.$tweet->screen_name}}</div></div><div class="clr"></div><div class="text">{!! $tweet->text !!}</div><div class="media">{!! $tweet->Image !!}</div></div>