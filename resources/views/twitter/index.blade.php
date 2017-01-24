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
    <div class="tweets" data-url="{{route('ajax.list')}}">
    </div>
</div>
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
    var showed = [];
    var listOfTweets = [
            @foreach($tweets as $tweet)
        {
            id: {{$tweet->id}},
            view: '{!! $tweet->view !!}'
        }
        @if($tweet != end($tweets))
        ,
        @endif
        @endforeach
    ];
</script>
<script src="/js/twit.js"></script>
</body>
</html>