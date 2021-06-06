var apiKey = "AIzaSyAZ0Co-nk2eOGd5x535zJV6E39gwu3s73Y";
var keyword;
var message;
function init() {
    gapi.client.setApiKey(apiKey);
    gapi.client.load("youtube", "v3", function () {
        console.log("Youtube API already");
    });
}

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher("3b2d88af5666682a41c0", {
    cluster: "ap1",
});

var channel = pusher.subscribe("room");
channel.bind("queue", function (data) {
    renderQueue(data);
});
channel.bind("play", function (data) {
    play(data);
});
channel.bind("messages", function (data) {
    renderMessages(data);
});

$("document").ready(function () {
    // Submit search form
    $("#form-search").on("submit", function (e) {
        e.preventDefault();
        keyword = $("#input-search").val();
        if (keyword == "") return;
        search(keyword);
    });

    // Search by keyword
    function search(keyword) {
        $.ajax({
            type: "GET",
            url: "https://www.googleapis.com/youtube/v3/search",
            data: {
                part: "snippet,id",
                q: keyword,
                maxResults: 100,
                type: "video",
                key: apiKey,
            },
            success: function (data) {
                //console.log(JSON.stringify(data));
                $("#result-list").html("");
                var content = "";
                for (var i = 0; i < data.items.length; i++) {
                    if (data.items.length > 0) {
                        content = content + getResults(data.items[i]);
                    }
                }
                $("#result-list").append(content);
            },
        });
    }

    // return item search
    function getResults(item) {
        // get properties of item
        var videoID = item.id.videoId;
        var title = item.snippet.title;
        var thumb = item.snippet.thumbnails.high.url;
        var channelTitle = item.snippet.channelTitle;
        var output =
            '<div class="row py-2 result-item" data-item-idvideo="' +
            videoID +
            '" data-item-thumbnail="' +
            thumb +
            '" data-item-title="' +
            title +
            '" data-item-channeltitle="' +
            channelTitle +
            '" onclick="addQueue(this)">' +
            '<img class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 result-item-thumbnail" src="' +
            thumb +
            '" alt="">' +
            '<div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8 result-item-info pl-3">' +
            '<div class="py-1 result-item-info-title">' +
            '<span class="result-item-info-title-text">' +
            title +
            "</span>" +
            "</div>" +
            '<div class="py-1 result-item-info-channel">' +
            channelTitle +
            "</div>" +
            "</div>" +
            "</div>";
        return output;
    }

    // Submit message form
    $("#form-message").on("submit", function (e) {
        e.preventDefault();
        message = $("#input-message").val();
        $("#input-message").val("");
        if (message == "") return;
        sendMessage(message);
    });

    // Send Message
    function sendMessage(message) {
        console.log(message);
        var idUser = $("#navbarDropdown").attr("data-iduser");
        var idRoom = $("#idRoom").attr("data-idroom");
        var token = $('input[name="_token"]').val();

        $.ajax({
            type: "post",
            url: "/rooms/messages",
            data: {
                message: message,
                idRoom: idRoom,
                idUser: idUser,
                _token: token,
            },
            success: function (data) {
                console.log(data);
            },
        });
    }
});

// show Chat Box
function showChatBox() {
    $("#showChatBox").removeClass("chat-box-btn-new").addClass("chat-box-btn");
}

// add Queue
function addQueue(item) {
    var idVideo = item.getAttribute("data-item-idvideo");
    var thumbnail = item.getAttribute("data-item-thumbnail");
    var title = item.getAttribute("data-item-title");
    var channeltitle = item.getAttribute("data-item-channeltitle");
    var idUser = $("#navbarDropdown").attr("data-iduser");
    var idRoom = $("#idRoom").attr("data-idroom");

    var token = $('input[name="_token"]').val();

    $.ajax({
        type: "POST",
        url: "/songs/queue",
        data: {
            idVideo: idVideo,
            thumbnail: thumbnail,
            title: title,
            channeltitle: channeltitle,
            idRoom: idRoom,
            idUser: idUser,
            _token: token,
        },
        success: function (data) {
            console.log(data);
        },
    });
}

// render Queue
function renderQueue(queue) {
    if (queue.length == 0) return;
    if (queue[0].idRoom != $("#idRoom").attr("data-idroom")) return;
    $("#queue").html("");
    var content = "";
    for (var i = 0; i < queue.length; i++) {
        if (queue.length > 0) {
            var item = `<div class="row queue-item my-3">
                    <div class="queue-item-title d-flex flex-column justify-content-center">
                        <span>${queue[i].title}
                        </span>
                    </div>
                    <div class="queue-item-play">
                        <button data-idsong="${queue[i].id}" onclick="playSong(this)" style="border: none;" type="button" class="btn btn-outline-success">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>`;
            content = content + item;
        }
    }
    $("#queue").append(content);
}

function nextSong() {
    var idRoom = $("#idRoom").attr("data-idroom");
    var token = $('input[name="_token"]').val();
    $.ajax({
        type: "POST",
        url: "/songs/next",
        data: {
            idRoom: idRoom,
            _token: token,
        },
        success: function (data) {
            console.log(data);
        },
    });
}

function playSong(song) {
    var idSong = song.getAttribute("data-idsong");
    var token = $('input[name="_token"]').val();

    $.ajax({
        type: "POST",
        url: "/songs/play",
        data: {
            idSong: idSong,
            _token: token,
        },
        success: function (data) {
            console.log(data);
        },
    });
}

// Render Messages
function renderMessages(messages) {
    if (messages.count == 0) return;
    var idRoom = $("#idRoom").attr("data-idroom");
    if (messages[0].idRoom != idRoom) return;
    if ($("#chatBoxModal").hasClass("show") == false) {
        $("#showChatBox")
            .removeClass("chat-box-btn")
            .addClass("chat-box-btn-new");
    }

    var boxChatBody = $("#box-chat-body");
    messages.reverse();
    boxChatBody.html("");
    var content = "";
    messages.forEach((message) => {
        var item = `<p><strong>${message.userName}: </strong>${message.message}</p>`;
        content += item;
    });
    $("#box-chat-body").append(content);
    console.log(messages);
}

// YOUTUBE
var player;

function play(video) {
    let idRoom = video.idRoom;
    if (idRoom != $("#idRoom").attr("data-idroom")) return;

    let idVideo = video.idVideo;
    let thumbnail = video.thumbnail;
    let title = video.title;

    if (player != null) {
        player.loadVideoById({
            videoId: idVideo,
            startSeconds: 0,
            suggestedQuality: "small",
        });
    } else {
        player = new YT.Player("player", {
            height: "582",
            width: "1035",
            videoId: idVideo,
            events: {
                onReady: onPlayerReady,
                onStateChange: onPlayerStateChange,
            },
        });
    }

    $("#playing-thumb").attr("src", thumbnail);
    $("#playing-disk").attr("src", thumbnail);
    $("#playing-title").html("");
    $("#playing-title").append(title);
}

function onPlayerReady(event) {
    event.target.playVideo();
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED) {
        var idUser = $("#navbarDropdown").attr("data-iduser");
        var idRoom = $("#idRoom").attr("data-idroom");
        var token = $('input[name="_token"]').val();
        if (idUser == idRoom) {
            $.ajax({
                type: "POST",
                url: "/songs/next",
                data: {
                    idRoom: idRoom,
                    _token: token,
                },
                success: function (data) {
                    console.log(data);
                },
            });
        }
    }
}

function stopVideo() {
    player.stopVideo();
}

function switchScreen() {
    var searchScreen = $(".main-left");
    var queueScreen = $(".main-right");
    var switchButton = $("#switch-btn");

    if (searchScreen.hasClass("d-none")) {
        switchButton.html('<i class="fa fa-music" aria-hidden="true"></i>');
        searchScreen.removeClass("d-none");
        queueScreen.addClass("d-none");
    } else {
        switchButton.html('<i class="fa fa-search" aria-hidden="true"></i>');
        queueScreen.removeClass("d-none");
        searchScreen.addClass("d-none");
    }
}
