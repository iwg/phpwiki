$(function(){
  $('a.action').click(function(){
    $(this).next().submit();
  });
});
