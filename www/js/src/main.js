var pages = [];

//@import '_homepage.js';

function init(ajax) {
    if (!ajax){
        $(function(){
            $.nette.init();
        });
    } // Nette.ajax.js

    // custom scripts for pages
    console.log(_page + ':' + _pageAction);
    if (pages[_page]) // function is available
        pages[_page](ajax); // call it


    // flashes
    flashes.forEach(function (flash) {
        $(document).ready(function(){
            alert(flash);
        });
    });
}

// main launching calls

$(document).ready(init());

$.nette.ext('custom', {
    complete: function () {
        init(true);
    }
});