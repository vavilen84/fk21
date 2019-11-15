$(document).ready(function () {

    $("#close-wrap").click(function () {
        $("#gallery-wrap").hide();
        $("body").removeClass("overflow-hidden");
    });
    $("#gallery-wrap #left-wrap").on("click", function () {
        var wrap = $("#gallery-wrap");
        var curImage = wrap.find("img");
        var imageId = curImage.attr("data-id");
        var targetEl = $("#lightgallery").find('img[data-id="' + imageId + '"]').parent();
        var prevEl = targetEl.prev();
        if (prevEl[0]) {
            replaceGalleryWrapImage(prevEl);
        }
    });
    $("#gallery-wrap #right-wrap").on("click", function () {
        var wrap = $("#gallery-wrap");
        var curImage = wrap.find("img");
        var imageId = curImage.attr("data-id");
        var targetEl = $("#lightgallery").find('img[data-id="' + imageId + '"]').parent();
        var nextEl = targetEl.next();
        if (nextEl[0]) {
            replaceGalleryWrapImage(nextEl);
        }
    });
    $(".gallery-image").on("click", function (e) {
        var curEl = $(this);
        e.preventDefault();
        $(window).scrollTop(0);

        replaceGalleryWrapImage(curEl);
    });

});

function replaceGalleryWrapImage(curEl) {
    var image = curEl.find("img").clone();

    $("#gallery-wrap #image").html(image);
    $("#gallery-wrap #description").html(curEl.find(".competition-image-info").html());
    $("#gallery-wrap").show();

    $("body").addClass("overflow-hidden");
    var galleryContent = $("#gallery-wrap #content");
    var galleryContentHeight = galleryContent.height();

    var maxWidth = 1200;
    var imageWidth = parseFloat(image.attr("data-width"));
    var imageHeight = parseFloat(image.attr("data-height"))
    if (imageWidth > maxWidth) {
        var ratio = maxWidth / imageWidth;
        imageHeight = imageHeight * ratio
    }
    var contentHeight = imageHeight + parseFloat(galleryContentHeight);

    var windowHeight = $(window).height();
    if (windowHeight > contentHeight) {
        var heightDiff = windowHeight - contentHeight;
        galleryContent.css("padding-top", (heightDiff / 2))
    }
}

function fixElementHeight(items, additinalPadding) {
    var maxHeight = 0;
    $.each(items, function (i, v) {
        var h = $(this).height();
        if (h > maxHeight) {
            if (additinalPadding) {
                h = h + additinalPadding;
            }
            maxHeight = h;
        }
    });
    $.each(items, function (i, v) {
        var h = $(this).height();
        var padding = (maxHeight - h) / 2;
        $(this).css("height", maxHeight).css("visibility", "visible").css("padding-top", padding);
    });
}