/* 드롭다운 페이드인 */
$('.dropdown').on('show.bs.dropdown', function(e) {
    $(this).find('.dropdown-menu').first().stop(true, true).fadeToggle(200);
});

$('.dropdown').on('hide.bs.dropdown', function(e) {
    $(this).find('.dropdown-menu').first().stop(true, true).fadeToggle(200);
});

$('.btn-group').on('show.bs.dropdown', function(e) {
    $(this).find('.dropdown-menu').first().stop(true, true).fadeToggle(200);
});

$('.btn-group').on('hide.bs.dropdown', function(e) {
    $(this).find('.dropdown-menu').first().stop(true, true).fadeToggle(200);
});
/* 드롭다운 페이드인 End */

/* 모달 포커스잡기 */
$('#login-modal').on('shown.bs.modal', function () {
    $('#wpName1').focus();
})
/* 모달 포커스잡기 End */

/* 광고 로드 */
var width = $(window).width();
if (width < 1024) {
    $(document).ready(function() {
        var right_ads = $(".right-ads").html();
        $(".bottom-ads").html(right_ads);
        $(".right-ads").remove();
        $('.adsbygoogle').each(function(){(adsbygoogle = window.adsbygoogle || []).push({});});
    });
} else {
    $('.adsbygoogle').each(function(){(adsbygoogle = window.adsbygoogle || []).push({});});
}
/* 광고 로드 End */
