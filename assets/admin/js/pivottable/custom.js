$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $("#output").on("click", "#features img", function () {
        $(".pvtRendererArea").addClass("full-screen");

        let elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) { /* Firefox */
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE/Edge */
            elem.msRequestFullscreen();
        }
    });

    $("#saveLoadAreaIndicator").click(function() {
        $("#saveLoadArea").toggleClass("active");
    });

    $(document).on("fullscreenchange", function() {
        if (!document.fullscreenElement) {
            $(".pvtRendererArea").removeClass("full-screen");
        }
    });

    $(window).resize(function () {
        setTimeout(function(){
            fixRendererAreaElementHeight();
            checkOrientation();
        }, 500);
    });


    checkOrientation();

    $(window).on("orientationchange", function(){
        setTimeout(function(){
            checkOrientation();
        }, 500);
    });

    $(".dropdown-menu .close").on("click", function (event) {
        $(this).parent().next().remove();
        $(this).parent().remove();
    });
});


function fixRendererAreaElementHeight() {
    let rendererAreaElement = $(".pvtRendererArea");
    rendererAreaElement.css({"height": ($(window).height() - rendererAreaElement.position().top - 10).toString() + "px"});
}

function checkOrientation(){
    var win = {
        w: window.innerWidth,
        h: window.innerHeight
    };
    if(win.w < 768){
        if(win.w < win.h){
            $("#war").css("display", "block");
            $("#main").css("display", "none");
        } 
        else{
            $("#main").css("display", "block");
            $("#war").css("display", "none");
        }
    }
    else{
        $("#main").css("display", "block");
        $("#war").css("display", "none");
    }
 
 }
 
 
