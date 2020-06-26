
$(function() {
  'use strict';

  $('.answer').on('click', function() {
    var $selected = $(this);
    if ($selected.hasClass('selected') || $selected.hasClass('nonselected')) {
      return;
    }
    $selected.addClass('selected');
    var answer = $selected.text();

      $.post('/_answer.php', {
        answer: answer,
        token: $('#token').val()
      }).done(function(res) {       
      $('.answer').each(function() {
          if (!($(this).text() === answer)) {
            $(this).addClass('nonselected');
          } 
        });
        $('#btn').removeClass('disabled');
      });
  });

  $('#btn').on('click', function() {
    if (!$(this).hasClass('disabled')) {
      location.reload();
    }
  });
});
  