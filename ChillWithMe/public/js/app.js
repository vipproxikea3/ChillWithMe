$(document).ready(function () {
    $("#updateRoomPass-btn").click(() => {
        $("#updateRoomPass-form").submit();
    });

    $("#form-inputIdRoom").submit((e) => {
        e.preventDefault();
        $("#final-inputIdRoom").val($("#inputIdRoom").val());
        $("#inputIdRoomModal").modal();
    });

    $(".user-join-room").on("click", function (e) {
        let item = e.target;
        $("#final-inputIdRoom").val(item.getAttribute("data-room"));
        $("#inputIdRoomModal").modal();
    });

    $("#getRoom-btn").click(() => {
        $("#final-form-inputIdRoom").submit();
    });

    $("#updateName-btn").click(() => {
        $("#form-update-name").submit();
    });

    $("#form-password").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    alert(data.msg);
                    window.location.href = "/home";
                }
            },
        });
    });

    $("#form-login").on("submit", function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else if (data.status == 1) {
                    alert(data.msg);
                    $("#email").val("");
                    $("#password").val("");
                } else if (data.status == 2) {
                    alert(data.msg);
                    window.location.href = "/home";
                }
            },
        });
    });

    $("#form-register").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    alert(data.msg);
                    $("#name").val("");
                    $("#email").val("");
                    $("#password").val("");
                    $("#password_confirmation").val("");
                    window.location.href = "/";
                }
            },
        });
    });
});
