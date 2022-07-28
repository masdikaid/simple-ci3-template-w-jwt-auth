$(document).ready(()=>{

    $('#login-form').validate({
        rules:{
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8
            }
        },
        messages:{
            email: {
                required: 'email harus di isi',
                email: 'format email belum benar',
            },
            password: {
                required: 'password harus di isi',
                minlength: 'minimal password 8 digit'
            }
        },
        errorElement: 'p',
        errorPlacement: (error, element)=>{
            error.insertAfter(element.next('label'))
            error.addClass('invalid-feedback font-weight-light')
        },
        highlight:(element, errorClass, validClass)=>{
            $(element).addClass('is-invalid').removeClass('is-valid')
        },
        unhighlight:(element, errorClass, validClass)=>{
            $(element).addClass('is-valid').removeClass('is-invalid')
        },
        submitHandler: function () {
            const hash = btoa($('#email').val() + '!@#$%' + $('#password').val())

            $.ajax({
                url: base_url+'auth/dologin',
                type: 'POST',
                data: {hash:hash},
                dataType: 'json',
                success: function (){
                    document.location.href = base_url;
                },
                error: function (xhr){
                    const err = JSON.parse(xhr.responseText)
                    $('#login-status').text(err['message']).removeClass('d-none')
                }
            })
        }
    })


})