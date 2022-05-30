$(function(){

    $(' #mobile-menu-open').on('click', function(){
        $('#sidebar').css('left', '0');
        $('#menu-screen-overlay').show();
    });

    $('#menu-screen-overlay').on('click', function(){
        $('#sidebar').css('left', '-80vw');
        $('#menu-screen-overlay').hide();
    });

    $(".org-row").on('click', function() {
        window.location = $(this).data("href");
    });

    function hideErrorBox(){
        $("#error-screen-overlay").hide();
        $("#error-box").hide();
    }

    $('#error-dismiss').click(function(){
        hideErrorBox();
    })

    $("#error-screen-overlay").click(function(){
        hideErrorBox();
    })

    function hideActionPrompt(){
        $("#action-screen-overlay").hide();
        $(".action-prompt").hide();
    }

    $(".action-button").click(function(){
        $("#action-screen-overlay").show();
        $(".action-prompt").css('display', 'flex');
    });

    $("#action-screen-overlay").click(function(){
        hideActionPrompt();
    });

    $(".action-cancel").click(function(){
        hideActionPrompt();
    });
})