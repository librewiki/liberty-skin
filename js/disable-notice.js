// eslint-disable-next-line
function disableNotice() {
  'use strict';
  $.cookie('disable-notice', 'yes', { expires: 1, path: '/', domain: 'librewiki.net', secure: false });
}
