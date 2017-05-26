$('.social-buttons>div').click(function () {
  'use strict';
  var selectedMedia = $(this).attr('class');
  var url = encodeURIComponent($(this).attr('data-url'));
  var text = $(this).attr('data-text');
  switch (selectedMedia) {
    case 'facebook':
      window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, 'facebook', 'width=800, height=400');
      break;
    case 'twitter':
      window.open('https://twitter.com/intent/tweet?text=[' + text + ']%0A&url=' + url + '&via=' + mw.config.values.wgSiteName + '&hashtags=' + text + ',' + mw.config.values.wgSiteName, 'twitter', 'width=800, height=350');
      break;
    default:
      break;
  }
});
