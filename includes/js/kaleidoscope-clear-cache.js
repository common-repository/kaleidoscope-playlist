jQuery(document).ready(function ($) {
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'get',
        dataType: 'json',
        data: {'action': 'kaleidoscope_cache_clear'},
        success: function (response) {
        }
    });
});


