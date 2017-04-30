function LoginManage() {
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
        .done(function(result) {
            var token = result.query.tokens.logintoken;
            $.ajax({
                url: mw.util.wikiScript('api'),
                type: 'post',
                data: {
                    action: 'clientlogin',
                    loginreturnurl: location.href,
                    username: $('#wpName1').val(),
                    password: $('#wpPassword1').val(),
                    rememberMe: $('#lgremember').prop('checked')? 1 : 0,
                    logintoken: token,
                    format: 'json'
                },
                dataType: 'json'
            })
            .done(function(result) {
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
                    window.location.reload();
                }
            });
        })
        return false;
    } catch (e) {
        return false;
    }
}

function RegisterManage() {
    try {
        $.ajax({
            url: mw.util.wikiScript('api'),
            type: 'post',
            data: {
                action: 'query',
                meta: 'tokens',
                type: 'createaccount',
                format: 'json'
            },
            dataType: 'json'
        })
        .done(function(result) {
            var token = result.query.tokens.createaccounttoken;
            $.ajax({
                url: mw.util.wikiScript('api'),
                type: 'post',
                data: {
                    action: 'createaccount',
                    createreturnurl: location.href,
                    username: $('#regName1').val(),
                    password: $('#regPassword1').val(),
                    retype: $('#regPassword2').val(),
                    createtoken: token,
                    format: 'json',
                    realname: $('#regRealname').val(),
                    email: encodeURIComponent($('#regEmail').val())
                },
                dataType: 'json'
            })
            .done(function(result) {
                if (result.createaccount.status !== 'PASS') {
                    switch (result.createaccount.status) {
                        case 'FAIL':
                            if (result.createaccount.message === 'The supplied credentials could not be used for account creation.') {
                                $('#modal-register-alert').addClass('alert-warning');
                                $('#modal-register-alert').fadeIn('slow');
                                $('#modal-register-alert').html('<strong>경고</strong></br>비밀번호 확인란을 입력해주세요.');
                            } else {
                                $('#modal-register-alert').addClass('alert-warning');
                                $('#modal-register-alert').fadeIn('slow');
                                $('#modal-register-alert').html(`<strong>경고</strong></br>${(result.createaccount.message).replace('\n', '<br>')}`);
                            }
                            break;
                        default:

                    }
                } else {
                    window.location.reload();
                }
            });
        })
        return false;
    } catch (e) {
        return false;
    }
}
