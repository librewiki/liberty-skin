$(function () {
  'use strict';
  $('.liberty-notice').on('closed.bs.alert', function () {
    $.cookie('disable-notice', 'yes', { expires: 1, path: '/', domain: 'librewiki.net', secure: false });
  });
});
