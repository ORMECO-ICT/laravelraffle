
import jQuery from 'jquery';
window.$ = jQuery;


$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.table').attr('style', 'width:100%;');

});
