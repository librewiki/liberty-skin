$(function () {
  'use strict';
  $('.liberty-notice').on('closed.bs.alert', function () {
    mw.cookie.set('disable-notice', 'yes', { expires: 3600 * 24, secure: false });
  });
});
