$(".social-buttons>div").click(function() {
    var click_id = $(this).attr('class');
    var url = encodeURIComponent($(this).attr('data-url'));
    var text = $(this).attr('data-text');
    switch(click_id) {
        case "facebook":
            window.open("http://www.facebook.com/sharer/sharer.php?u=" + url,"facebook", "width=800, height=400");
            break;
        case "twitter":
            window.open("https://twitter.com/intent/tweet?text=" + text + "&url=" + url + "&via=Librewiki", "facebook", "width=800, height=350");
            break;
        case "twitter":
            break;
        default:
            break;
    }
});
