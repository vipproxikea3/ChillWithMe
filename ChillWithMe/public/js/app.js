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
