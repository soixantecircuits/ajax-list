(function ( $ ) {
	"use strict";

	$(function () {
    $( '#add-row' ).on('click', function() {
      var id_count =  parseInt($( '.empty-row.screen-reader-text .page-selector select' ).attr('id'));
      $('.empty-row.screen-reader-text .page-selector select' ).attr('id', id_count + 1);
      var row = $( '.empty-row.screen-reader-text' ).clone(true);
      row.removeClass( 'empty-row screen-reader-text' );
      row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
      assignOrder();
      return false;
    });

    $( '.remove-row' ).on('click', function() {
      $(this).parents('tr').remove();
      assignOrder();
      return false;
    });

    $('#ajax-list-container').on("sortstop", function( event, ui ) {
      assignOrder();
    });

    function assignOrder(){
      $("#ajax-list-container .ajax-list-item").each(function(index) {
        var count = index;
        $(this).find(".ordering").val(count);
      });
    }

    assignOrder();

    $("#ajax-list-container").sortable({
      items: '.ajax-list-item'
    });
	});

}(jQuery));