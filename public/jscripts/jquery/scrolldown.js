$.fn.ScrollLoad = function(ops) {
  ops = jQuery.extend({
    onLoad: false
  }, ops);
  
  return this.each(function(){
    var dummy = $(this);
    $(window).scroll(function() {
      var offset = dummy.offset();
      if (($(window).scrollTop() + $(window).height() - dummy.height()) > offset.top) {
        if (typeof ops.onLoad == 'function') ops.onLoad();
      };
    });
  });
};
