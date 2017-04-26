var pages = [];

//@import '_homepage.js';

function init(ajax) {
    if (!ajax) $.nette.init(); // Nette.ajax.js

    // remove GET parameters
    window.history.pushState('', '', window.location.pathname);

    // custom scripts for pages
    console.log(_page + ':' + _pageAction);
    if (pages[_page]) // function is available
        pages[_page](ajax); // call it


    // flashes
    flashes.forEach(function (flash) {
        // TODO flashes showing
    });
}

// main launching calls

$(document).ready(init());

$.nette.ext('custom', {
    complete: function () {
        init(true);
    }
});