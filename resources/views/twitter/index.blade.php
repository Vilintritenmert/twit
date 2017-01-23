<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/tweet.css">
    <title>Document</title>
</head>
<body>
<div class="content">
    <div class="tweets">
        @foreach($tweets as $tweet)
            <div class="tweet">
                <div class="header">
                    <div class="logo"><img src="{{$tweet->logo}}"></div>
                    <div class="name">{{$tweet->name}}</div>
                    <div class="created_at">{{$tweet->time}}</div>
                    <div class="login">{{'@'.$tweet->screen_name}}</div>
                </div>
                <div class="clr"></div>
                <div class="text">
                    {!! $tweet->text !!}
                </div>
                <div class="media">
                    {!! $tweet->Image !!}
                </div>
            </div>
        @endforeach
    </div>
</div>
<script src="/js/jquery-3.1.1.min.js"></script>
<script src="/js/twit.js"></script>
<script>
    var listOfTweets = [
            @foreach($tweets as $tweet)
        {
            id:{{$tweet->id}},
            logo:'{{$tweet->logo}}',
            name:'{{$tweet->name}}',
            created_at:'{{$tweet->time}}',
            login:'{{$tweet->login }}',
            text:'{!! $tweet->text !!}',
            image:'{!! $tweet->image !!}'
        }
            @if($tweet != end($tweets))
            ,
            @endif
        @endforeach
    ];
</script>
</body>
</html>