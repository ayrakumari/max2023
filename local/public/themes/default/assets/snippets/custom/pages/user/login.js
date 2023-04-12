$('.aj_otp').hide();
$('#otp_token').val("");
$('#m_login_signin_submit_verify').hide();
var SnippetLogin = function() {
    var e = $("#m_login"),
        i = function(e, i, a) {
            var l = $('<div class="m-alert m-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
            e.find(".alert").remove(), l.prependTo(e), mUtil.animateClass(l[0], "fadeIn animated"), l.find("span").html(a)
        },
        a = function() {
            e.removeClass("m-login--forget-password"), e.removeClass("m-login--signup"), e.addClass("m-login--signin"), mUtil.animateClass(e.find(".m-login__signin")[0], "flipInX animated")
        },
        l = function() {
            $("#m_login_forget_password").click(function(i) {
                i.preventDefault(), e.removeClass("m-login--signin"), e.removeClass("m-login--signup"), e.addClass("m-login--forget-password"), mUtil.animateClass(e.find(".m-login__forget-password")[0], "flipInX animated")
            }), $("#m_login_forget_password_cancel").click(function(e) {
                e.preventDefault(), a()
            }), $("#m_login_signup").click(function(i) {
                i.preventDefault(), e.removeClass("m-login--forget-password"), e.removeClass("m-login--signin"), e.addClass("m-login--signup"), mUtil.animateClass(e.find(".m-login__signup")[0], "flipInX animated")
            }), $("#m_login_signup_cancel").click(function(e) {
                e.preventDefault(), a()
            })
        };
    return {
        init: function() {

            l(), $("#m_login_signin_submit").click(function(e) {

                e.preventDefault();
                var a = $(this),
                    l = $(this).closest("form");
                l.validate({
                    rules: {
                        email: {
                            required: !0,
                            email: !0
                        },
                        password: {
                            required: !0
                        }
                    }
                }), l.valid() && (l.ajaxSubmit({
                    //url: BASE_URL+'/login',
                    url: BASE_URL+'/customLogin',
                    success: function(e, t, r, s) {

                     if(e.status==1){

                        $('.aj_login_otp').hide('slow');
                        $('.aj_otp').show('slow');
                        $('#otp_login').val("");
                        $('#otp_login').focus();
                        $('#otp_token').val(e.login_token);
                        $('#m_login_signin_submit').hide();
                        $('#m_login_signin_submit_verify').show('slow');
                     }
                     if(e.status==2){
                        location.reload();
                        //window.location.href = BASE_URL+'/getIndData';
                     }
                     if(e.status==0){
                        return swal({
                            title:  'Login',
                            text: 'The given data was invalid.',
                            type: "error",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        }), !1
                     }



                    //location.reload();


                    },
                    dataType : 'json',
                    error: function(res) {
                        console.log(res);

                        if(res.responseJSON.errors.email[0]){
                             return swal({
                               title:  res.responseJSON.errors.email[0],
                               text: 'The given data was invalid.',
                               type: "error",
                               confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                           }), !1

                        }
                        location.reload();
                      }

                }))
            }), $("#m_login_signin_submit_verify").click(function(e) {

                e.preventDefault();
                var a = $(this),
                    l = $(this).closest("form");
                l.validate({
                    rules: {
                        otp: {
                            required: !0,
                        },
                        otp_token: {
                            required: !0
                        }
                    }
                }), l.valid() && (l.ajaxSubmit({
                    //url: BASE_URL+'/login',
                    url: BASE_URL+'/LoginOTPVerify',
                    success: function(e, t, r, s) {




                     if(e.status){

                             location.reload();

                     }else{
                        return swal({
                            title:  'OTP Verification',
                            text: 'Incorrect OTP',
                            type: "error",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        }), !1
                     }



                    },
                    dataType : 'json',
                    error: function(res) {
                        console.log(res);

                        if(res.responseJSON.errors.email[0]){
                             return swal({
                               title:  res.responseJSON.errors.email[0],
                               text: 'The given data was invalid.',
                               type: "error",
                               confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                           }), !1

                        }
                        location.reload();
                      }

                }))
            }),
            $("#otp_login").keypress(function(event) {
          
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
              
                //e.preventDefault();
                var a = $(this),
                    l = $(this).closest("form");
                l.validate({
                    rules: {
                        otp: {
                            required: !0,
                        },
                        otp_token: {
                            required: !0
                        }
                    }
                }), l.valid() && (l.ajaxSubmit({
                    //url: BASE_URL+'/login',
                    url: BASE_URL+'/LoginOTPVerify',
                    success: function(e, t, r, s) {




                     if(e.status){

                             location.reload();

                     }else{
                        return swal({
                            title:  'OTP Verification',
                            text: 'Incorrect OTP',
                            type: "error",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        }), !1
                     }



                    },
                    dataType : 'json',
                    error: function(res) {
                        console.log(res);

                        if(res.responseJSON.errors.email[0]){
                             return swal({
                               title:  res.responseJSON.errors.email[0],
                               text: 'The given data was invalid.',
                               type: "error",
                               confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                           }), !1

                        }
                        location.reload();
                      }

                }))
                
                
            }
    
            
           
            }),

             $("#m_login_signup_submit").click(function(l) {
                l.preventDefault();
                var t = $(this),
                    r = $(this).closest("form");
                r.validate({
                    rules: {
                        fullname: {
                            required: !0
                        },
                        email: {
                            required: !0,
                            email: !0
                        },
                        password: {
                            required: !0
                        },
                        rpassword: {
                            required: !0
                        },
                        agree: {
                            required: !0
                        }
                    }
                }), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                    url: "http://boconnect.local/userLogin",
                    success: function(l, s, n, o) {
                        setTimeout(function() {
                            t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), a();
                            var l = e.find(".m-login__signin form");
                            l.clearForm(), l.validate().resetForm(), i(l, "success", "Thank you. To complete your registration please check your email.")
                        }, 2e3)
                    }
                }))
            }), $("#m_login_forget_password_submit").click(function(l) {
                l.preventDefault();
                var t = $(this),
                    r = $(this).closest("form");
                r.validate({
                    rules: {
                        email: {
                            required: !0,
                            email: !0
                        }
                    }
                }), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                    url: "http://boconnect.local/userLogin",
                    success: function(l, s, n, o) {
                        setTimeout(function() {
                            t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), a();
                            var l = e.find(".m-login__signin form");
                            l.clearForm(), l.validate().resetForm(), i(l, "success", "Cool! Password recovery instruction has been sent to your email.")
                        }, 2e3)
                    }
                }))
            })
        }
    }
}();
jQuery(document).ready(function() {
    SnippetLogin.init()
});
