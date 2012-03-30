$(document).ready(function() {
    // highlight current controller
    var def = 'blog/';
    $('nav a').each(function() {
        if ($(this).attr('href').substr(window.location.pathname.length) == def ||
            $(this).attr('href') == window.location.pathname.substr(0, $(this).attr('href').length))
        {
            $(this).addClass('active');
            return false;
        }
    });
});