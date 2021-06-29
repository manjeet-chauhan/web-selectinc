var cw = $('.UserImage img').width();
$('.UserImage img').css({
    'height': cw + 'px'
});

// var cw = $('.Notification span').width();
// $('.Notification span').css({
//     'height': cw + 'px'
// });

var cw = $('.NotificationImage img').width();
$('.NotificationImage img').css({
    'height': cw + 'px'
});

// var ch = $('.DashboardNavigation').width();
// $('.Logout').css({
//     'width': ch + 'px'
// });

$("DashboardNavigation ul li").click(function(){
  $("DashboardNavigation ul li i").toggleClass("Rotate");
});


$("#datepicker").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
});


