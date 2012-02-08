$(function(){
  $('a.remove').click(function(){
    if (confirm('Are you sure to remove it?')) {
      $(this).next().submit();
    }
  });
  $('a.add').click(function(){
    $(this).prev().submit();
  });
});
