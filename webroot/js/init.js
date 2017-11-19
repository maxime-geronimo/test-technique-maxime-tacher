
var BaseUrl;

function init_baseurl(url){
    BaseUrl = url.substr(0,url.length-1);
}


$(document).ready(function(e){
    //Initialize modals
    init_modal();

    //Initialize tooltips
    init_tooltip();

    //Transitions init
    $('.gallery').removeClass('scale-out').addClass('scale-in');
    $('.btn-add').removeClass('scale-out').addClass('scale-in');

});

function init_modal(){
    $('.modal').modal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            inDuration: 300, // Transition in duration
            outDuration: 200, // Transition out duration
            startingTop: '4%', // Starting top style attribute
            endingTop: '20%', // Ending top style attribute
            ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.

            },
            complete: function() {
                console.log('complete');
                $('body').removeClass('popup-open');
            }
        }
    );
}

function init_tooltip(){
    $('.tooltipped').tooltip({delay: 5});
}
