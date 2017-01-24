jQuery(document).ready(function () {


    updateTweets(listOfTweets);

    setInterval(getTweets, 5000);

});


/**
 * Get list of tweets
 */
function getTweets() {
    var url = jQuery('.tweets').attr('data-url');

    jQuery.ajax({
        method: 'get',
        url: url,
        success: function (response) {
            if (response)
                updateTweets(response);
        }
    })
}

/**
 * Show Tweets
 *
 * @param items
 */
function updateTweets(items) {

        jQuery(items).each(function (key, item) {
            $exist = jQuery.grep(showed, function(i){ return i.id == item.id ; });
            if(!$exist.length){


                $new = jQuery(item.view).prependTo('.tweets');
                $new.addClass('new');

                setTimeout(function removeNew(){
                    jQuery('.new').removeClass('new');

                },1000);
                showed.push(item);
            }
        });


}


