function LoginManage(lasturl) {
    var params = jQuery("#modal-loginform").serialize(); // serialize() : 입력된 모든Element(을)를 문자열의 데이터에 serialize 한다.
    var final_result = false;
    var url = "/wiki/" + lasturl;
    $.ajax({
        url: '/api.php',
        type: 'post',
        data:params,
        async: false,
        dataType: 'json',
        success: function (result) {
            if (result) {
                var login_result = result.login.result;
                switch (login_result) {
                    case "NeedToken":
                        $.ajax({
                            url: '/api.php',
                            type: 'post',
                            async:false,
                            data:params + '&lgtoken=' + result.login.token,
                            dataType: 'json',
                            success: function(loginend) {
                                if (loginend) {
                                    var login_result2 = loginend.login.result;
                                    switch (login_result2) {
                                        case "EmptyPass":
                                            $("#modal-login-alert").addClass('alert-warning');
                                            $("#modal-login-alert").fadeIn("slow");
                                            $("#modal-login-alert").html("<strong>경고!!!</strong></br>비밀번호를 입력해 주세요.");
                                            final_result = false;
                                            break;
                                        case "WrongPass":
                                            $("#modal-login-alert").addClass('alert-danger');
                                            $("#modal-login-alert").fadeIn("slow");
                                            $("#modal-login-alert").html("<strong>실패!!!</strong></br>비밀번호가 잘못되었습니다.");
                                            final_result = false;
                                            break;
                                        case "NotExists":
                                            $("#modal-login-alert").addClass('alert-danger');
                                            $("#modal-login-alert").fadeIn("slow");
                                            $("#modal-login-alert").html("<strong>실패!!!</strong></br>아이디가 존재하지 않습니다.");
                                            final_result = false;
                                            break;
                                        case "Throttled":
                                            $("#modal-login-alert").addClass('alert-warning');
                                            $("#modal-login-alert").fadeIn("slow");
                                            $("#modal-login-alert").html("<strong>경고!!!</strong></br>너무 많은 로그인시도를 하였습니다.</br>5분동안 로그인시도가 불가능합니다.");
                                            final_result = false;
                                            break;
                                        case "Success":
                                            final_result = false;
                                            $(location).attr('href',url);
                                            break;
                                        default:
                                            final_result = false;
                                            break;
                                    }
                                }
                            }
                        });
                        break;
                    case "NoName":
                        $("#modal-login-alert").addClass('alert-warning');
                        $("#modal-login-alert").fadeIn("slow");
                        $("#modal-login-alert").html("<strong>경고!!!</strong></br>아이디를 입력해 주세요.");
                        final_result = false;
                        break;
                    default:
                        final_result = false;
                        break;
                }
            }
        }
    });
    return final_result;
}