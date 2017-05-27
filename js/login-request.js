// eslint-disable-next-line
function LoginManage() {
  'use strict';
  try {
    $.ajax({
      url: mw.util.wikiScript('api'),
      type: 'post',
      data: {
        action: 'query',
        meta: 'tokens',
        type: 'login',
        format: 'json'
      },
      dataType: 'json'
    })
    .done(function (result) {
      var token = result.query.tokens.logintoken;
      $.ajax({
        url: mw.util.wikiScript('api'),
        type: 'post',
        data: {
          action: 'clientlogin',
          loginreturnurl: location.href,
          username: $('#wpName1').val(),
          password: $('#wpPassword1').val(),
          rememberMe: $('#lgremember').prop('checked') ? 1 : 0,
          logintoken: token,
          format: 'json'
        },
        dataType: 'json'
      })
      .done(function (result) {
        if (result.clientlogin.status !== 'PASS') {
          switch (result.clientlogin.status) {
            case 'FAIL':
              if (result.clientlogin.message === 'The supplied credentials could not be authenticated.') {
                $('#modal-login-alert').addClass('alert-warning');
                $('#modal-login-alert').fadeIn('slow');
                $('#modal-login-alert').html('<strong>경고</strong></br>아이디와 비밀번호를 정확히 입력하세요.');
              } else {
                $('#modal-login-alert').addClass('alert-warning');
                $('#modal-login-alert').fadeIn('slow');
                $('#modal-login-alert').html(result.clientlogin.message);
              }
              break;
            default:

          }
        } else {
          window.location == '/wiki/%ED%8A%B9%EC%88%98:%EB%A1%9C%EA%B7%B8%EC%95%84%EC%9B%83' ? $(location).attr('href', '/wiki') : window.location.reload();
        }
      });
    });
    return false;
  } catch (e) {
    return false;
  }
}
