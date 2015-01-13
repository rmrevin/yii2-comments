(function ($) {
  $.fn.yiiCommentsList = function (method) {
    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method) {
      return methods.init.apply(this, arguments);
    } else {
      $.error('Method ' + method + ' does not exist on jQuery.yiiCommentsList');
      return false;
    }
  };

  var commentsData = [];

  var methods = {
    init: function (comments) {
      commentsData = comments;
    }
  };

  $('[data-role="reply"]').bind('click', function (e) {
    var comment_id = $(this).closest('[data-comment]').data('comment'),
      $textarea = $('textarea[data-role="new-comment"]');

    $textarea
      .focus()
      .val(blockquote(commentsData[comment_id].text));

    location.hash = null;
    location.hash = 'commentcreateform';

    e.preventDefault();
  });

  $('[data-role="edit"]').bind('click', function (e) {
    var $link = $(this),
      $comment = $link.closest('[data-comment]'),
      comment_id = $comment.data('comment'),
      comment = commentsData[comment_id],
      $edit_block = $comment.find('.edit');

    $edit_block.show();

    $edit_block.find('form').bind('reset', function () {
      $edit_block.hide();
    });

    e.preventDefault();
  });

  function blockquote(text) {
    return text.split('\n').map(function (value) {
        return '> ' + value;
      }).join('\n') + '\n\n';
  }
})(window.jQuery);
