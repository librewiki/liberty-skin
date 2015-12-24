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