$('.social-buttons>div').click(function () {
  'use strict';
  var selectedMedia = $(this).attr('class');
  var url = encodeURIComponent($(this).attr('data-url'));
  var text = $(this).attr('data-text');
  switch (selectedMedia) {
    case 'facebook':
      window.open('http://www.facebook.com/sharer/sharer.php?u=' + url, 'facebook', 'width=800, height=400');
      break;
    case 'twitter':
      window.open('https://twitter.com/intent/tweet?text=' + text + '&url=' + url + '&via=리브레위키&hashtags=LibreWiki', 'facebook', 'width=800, height=350');
      break;
    default:
      break;
  }
});
