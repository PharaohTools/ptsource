
$('#hide_menu_button').on('click', function() {
    $('#page_sidebar').css('display', 'none');
    pageCon = $('#page_content') ;
    pageCon.removeClass('col-lg-9');
    pageCon.addClass('col-lg-12');
    $('#show_menu_wrapper').css('display', 'block');
    path_header = $('#path_header') ;
    path_header.removeClass('col-lg-12');
    path_header.addClass('col-lg-9');
});

$('#show_menu_button').on('click', function() {
    $('#page_sidebar').css('display', 'block');
    pageCon = $('#page_content') ;
    pageCon.removeClass('col-lg-12');
    pageCon.addClass('col-lg-9');
    $('#show_menu_wrapper').css('display', 'none');
    path_header = $('#path_header') ;
    path_header.removeClass('col-lg-9');
    path_header.addClass('col-lg-12');
});
