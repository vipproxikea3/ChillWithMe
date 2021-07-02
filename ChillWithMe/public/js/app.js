// const { error } = require("jquery");
// const { spread } = require("lodash");

$(document).ready(function () {
    $("#updateRoomPass-btn").click(() => {
        $("#updateRoomPass-form").submit();
    });

    $("#form-inputIdRoom").submit((e) => {
        e.preventDefault();
        $("#final-inputIdRoom").val($("#inputIdRoom").val());
        $("#inputIdRoomModal").modal();
    });

    $("#getRoom-btn").click(() => {
        $("#final-form-inputIdRoom").submit();
    });
});

    $('#form-password').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
                $(document).find('span.error-text').text('');
            },
            success:function(data){
                if(data.status == 0){
                    $.each(data.error, function(prefix, val){
                        $('span.'+ prefix +'_error').text(val[0]);
                    });
                } else {
                    alert(data.msg);
                    window.location.href = '/home';
                }
            }
        });
    });