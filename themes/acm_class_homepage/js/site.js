$(function(){ 
  $('.slideshow').cycle({
    fx: 'fade',
    timeout: 7000,
    pager: "#pager"
  });
  $('a').click(function(){ $(this).blur(); });
});
