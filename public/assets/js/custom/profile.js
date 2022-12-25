$("#profile_frm").validate({
    rules: {
        first_name: {
            required: true,
            lettersonly: true
        },
        last_name: {
            required: true,
            lettersonly: true
        },
        name: {
            required: true,
        },
        image: {
            accept: "image/jpg,image/jpeg,image/png"
        },
    },
    messages: {
        first_name: {
            required: "Please enter firstname",
            lettersonly: "Please enter valid firstname"
        },
        last_name: {
            required: "Please enter lastname",
            lettersonly: "Please enter valid lastname"
        },
        name: {
            required: "Please enter name",
            remote: "Username already taken!"
        },
        image: {
            accept: 'Only allow image!'
        },
    },
    submitHandler: function (form, e) {
        e.preventDefault();
        console.log(form)
        const formbtn = $('#profile_frm_btn');
        const formloader = $('#profile_frm_loader');
        console.log(formloader)
        $.ajax({
            url: form.action,
            type: "POST",
            data: new FormData(form),
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrf_token },
            beforeSend: function () {
                formloader.show();
                formbtn.prop('disabled', true);
            },
            success: function (result) {
                formloader.hide();
                formbtn.prop('disabled', false);
                if (result.status) {
                    toastr.success(result.message);
                } else {
                    toastr.error(result.message);
                }
            },
            error: function () {
                toastr.error('Please Reload Page.');
                formloader.hide();
                formbtn.prop('disabled', false);
            }
        });
        return false;
    }
});

$("#password_frm").validate({
    rules: {
        old_password: {
            required: true,
            minlength: 6,
        },
        password: {
            required: true,
            minlength: 6,
        },
        password_confirmation: {
            required: true,
            equalTo: "#password"
        },
    },
    messages: {

        old_password: {
            required: "Please enter old password",
            minlength: "Please enter old password atleast 6 character!"
        },
        password: {
            required: "Please enter password",
            minlength: "Please enter password atleast 6 character!"
        },
        password_confirmation: {
            required: "Please enter confirm password"
        },

    },
    submitHandler: function (form, e) {
        e.preventDefault();
        const formbtn = $('#password_frm_btn');
        const formloader = $('#password_frm_loader');
        $.ajax({
            url: form.action,
            type: "POST",
            data: new FormData(form),
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrf_token },
            beforeSend: function () {
                $(formloader).show();
                $(formbtn).prop('disabled', true);
            },
            success: function (result) {
                $(formloader).hide();
                $(formbtn).prop('disabled', false);
                if (result.status) {
                    $("#password,#password_confirmation,#old_password").val('');
                    toastr.success(result.message);
                } else {
                    toastr.error(result.message);
                }
            },
            error: function () {
                toastr.error('Please Reload Page.');
                $(formloader).hide();
                $(formbtn).prop('disabled', false);
            }
        });
        return false;
    }
});

$("#setting_frm").validate({
    rules: {
        support_email: {
            required: true,email:true
        },
        contact: {
            required: true,
            minlength: 10,
            maxlength: 10,
            number:true
        },
        address: {
            required: true,
            minlength: 6
        },
        logo_image: {
            accept: "image/jpg,image/jpeg,image/png"
        },
        facebook: {
            url:true
        },
        twitter: {
            url:true
        },
        linkedin: {
            url:true
        },
        instagram: {
            url:true
        },
    },
    messages: {

        old_password: {
            required: "Please enter old password",
            minlength: "Please enter old password atleast 6 character!"
        },

        support_email: {
            required: 'Please enter support email',
            email:'Support email should be valid email address.'
        },
        contact: {
            required: 'Please enter support contact',
            number:true
        },
        address: {
            required: 'Please enter support address',
            minlength: 'Please enter address atleast 6 character!'
        },
        logo_image: {
            accept: 'Only allow image!'
        },
        facebook: {
            url:'Facebook should be valid URL.'
        },
        twitter: {
            url:'Twitter should be valid URL.'
        },
        linkedin: {
            url:'Linkedin should be valid URL.'
        },
        instagram: {
            url:'Instagram should be valid URL.'
        },

    },
    submitHandler: function (form, e) {
        e.preventDefault();
        const formbtn = $('#setting_frm_btn');
        const formloader = $('#setting_frm_loader');
        $.ajax({
            url: form.action,
            type: "POST",
            data: new FormData(form),
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrf_token },
            beforeSend: function () {
                $(formloader).show();
                $(formbtn).prop('disabled', true);
            },
            success: function (result) {
                $(formloader).hide();
                $(formbtn).prop('disabled', false);
                if (result.status) {
                    toastr.success(result.message);
                } else {
                    toastr.error(result.message);
                }
            },
            error: function () {
                toastr.error('Please Reload Page.');
                $(formloader).hide();
                $(formbtn).prop('disabled', false);
            }
        });
        return false;
    }
});
