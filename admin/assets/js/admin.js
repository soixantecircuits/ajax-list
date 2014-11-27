(function ( $ ) {
	"use strict";

	$(function () {
    var simple_fields_new_fields_count = 0;
		// Place your administration-specific JavaScript here
    $(document).on("click", "div.ajax-list-metabox-field-add a:nth-child(1)", function(e) {

      var $t = $(this).closest("div.simple-fields-metabox-field-add");

      var $wrapper = $t.parents(".simple-fields-meta-box-field-group-wrapper");
      var post_id = jQuery("#post_ID").val();

      var data = {
        "action": 'al_metabox_fieldgroup_add',
        "simple_fields_new_fields_count": simple_fields_new_fields_count,
        "post_id": post_id
      };
      console.log(data);
      console.log(ajaxurl);
      var is_link_at_bottom = $t.hasClass("simple-fields-metabox-field-add-bottom");

      $.post(ajaxurl, data, function(response) {
        console.log(response);
        var $ul = $wrapper.find("ul.simple-fields-metabox-field-group-fields");
        var $response = $( response.replace(/^\s+/, '') );
        $response.hide();
        if (is_link_at_bottom) {
          $ul.append($response);
        } else {
          $ul.prepend($response);
        }

        var wrapper = $ul.closest("div.simple-fields-meta-box-field-group-wrapper");

        $response.slideDown("slow", function() {

          simple_fields_metabox_tinymce_attach();

          // add jscolor to possibly new fields
          jscolor.init();

          // add datepicker too
          $('input.simple-fields-field-type-date', $ul).datePicker(simple_fields_datepicker_args);

          // Fire event so plugins can listen to the add-button
          $(document.body).trigger("field_group_added", $response);

        });

        $t.html("<a href='#'>+ "+sfstrings.add+"</a>");

        wrapper.addClass("simple-fields-meta-box-field-group-wrapper-has-fields-added");

      });

      simple_fields_new_fields_count++;

      return false;
    });
	});

}(jQuery));