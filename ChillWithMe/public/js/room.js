var apiKey = "AIzaSyAZ0Co-nk2eOGd5x535zJV6E39gwu3s73Y";
var keyword;
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

var channel = pusher.subscribe("test-channel");
channel.bind("test-event", function (data) {
    renderQueue(data);
});

$("document").ready(function () {
    // Submit search form
    $("#form-search").on("submit", function (e) {
        e.preventDefault();
        keyword = $("#input-search").val();
        if (keyword == "") return;
        console.log(keyword);
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
            '<div class="row p-2 result-item" data-item-idvideo="' +
            videoID +
            '" data-item-thumbnail="' +
            thumb +
            '" data-item-title="' +
            title +
            '" data-item-channeltitle="' +
            channelTitle +
            '" onclick="addQueue(this)">' +
            '<img class="result-item-thumbnail" src="' +
            thumb +
            '" alt="">' +
            '<div class="result-item-info pl-3">' +
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
});

// add Queue
function addQueue(item) {
    var idVideo = item.getAttribute("data-item-idvideo");
    var thumbnail = item.getAttribute("data-item-thumbnail");
    var title = item.getAttribute("data-item-title");
    var channeltitle = item.getAttribute("data-item-channeltitle");
    var idUser = $("#navbarDropdown").attr("data-iduser");
    var idRoom = $("#navbarDropdown").attr("data-idroom");

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
    $("#queue").html("");
    var content = "";
    for (var i = 0; i < queue.length; i++) {
        if (queue.length > 0) {
            var item = `<div class="row queue-item my-3 px-5">
                    <div class="queue-item-title d-flex flex-column justify-content-center">
                        <span>${queue[i].title}
                        </span>
                    </div>
                    <div class="queue-item-play">
                        <button style="border: none;" type="button" class="btn btn-outline-success">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>`;
            content = content + item;
        }
    }
    $("#queue").append(content);
}
