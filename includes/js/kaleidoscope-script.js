// jQuery(document).ready(function ($) {
//     $.ajax({
//         url: kaleidoscope_ajax_object.ajax_url,
//         type: 'post',
//         dataType: 'json',
//         data: {'action': 'my_action', 'getData': '1'},
//         success: function (response) {
//             // setTimeout(slider, 500)
//             // function slider() {
//                 $('.kaleidoscope-slider').kaleidoscopeSlider({
//                     slideShow: response.autoplay,
//                     interval: response.interval,
//                     animation: response.animation
//                 });
                
//                 if(response.bg_color) {
//                     var opacity = response.bg_transparent;
//                     var color = response.bg_color;
//                     var rgbaCol = 'rgba(' + parseInt(color.slice(-6, -4), 16) + ',' + parseInt(color.slice(-4, -2), 16) + ',' + parseInt(color.slice(-2), 16) + ',' + opacity + ')';
//                 } else {
//                     var opacity = 0.05;
//                     var rgbaCol = 'rgba(' + 0 + ',' + 0 + ',' + 0 + ',' + opacity + ')';
//                 }
    
//                 $('.kaleidoscope-slider').css('background-color', rgbaCol)
    
//                 if(response.border=='yes' && !response.border_color) {
//                     $('.kaleidoscope-slider').css('border', '4px solid black')
//                 }
    
//                 if(response.border=='yes' && response.border_color) {
//                     var border_color = response.border_color;
//                     var rgbColor = 'rgb(' + parseInt(border_color.slice(-6, -4), 16) + ',' + parseInt(border_color.slice(-4, -2), 16) + ',' + parseInt(border_color.slice(-2), 16) +  ')';
//                     $('.kaleidoscope-slider').css('border', '4px solid '+ rgbColor)
//                 }
    
//                 $('.kaleidoscope-slider .kaleidoscope-slide img').css('object-fit', response.image_fit)
//             // }
            
            
//         }
//     });
// });


