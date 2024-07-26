"use strict";
//https://support.advancedcustomfields.com/forums/topic/sending-user-to-tab-on-validation-errors/
(function ($) {
  $(document).ready(function () {
    acf.add_filter('validation_complete', function (json) {
      if (json.errors) {
          $.each(json.errors, function (index) {
              var field = $('[name="' + json.errors[index].input + '"]').parents('.acf-field');
              var repeater = field[1];
              var previous_tabs = $(repeater).prevAll('[data-type="tab"]');
              var tab_data_key = $(previous_tabs[0]).attr('data-key');
              $('.acf-tab-wrap a[data-key=' + tab_data_key + ']').click();
          });
      }
      return json;
    });

    function triggerTemplateSelection() {
      var location = window.document.location;
      if (!location.pathname.includes('wp-admin/post-new.php')) return;

      var select = $("#page_template");
      setTimeout(() => { // Timeout needed in order to trigger the admin-ajax.php endpoint.
        select.trigger('change');
      }, 250);
      
    };
    triggerTemplateSelection();
    
    function ImageOrForm() {
      var img_elem = $( "#acf-field_62b0b549e9f52-field_62b0b6b0f143e_field_62a21f4e38875-field_63e193c70b4a4-image" );
      var form_elem = $( "#acf-field_62b0b549e9f52-field_62b0b6b0f143e_field_62a21f4e38875-field_63e193c70b4a4-form" );

      var form_fields = ["form_select_form", "form_reporting_title", "form_persona", "form_initiative", "form_stage", "form_co_code", "form_product", "form_type", "form_next_form", "form_redirect_url", "form_marketing_opt_in_checkbox", "form_terms_opt_in_checkbox", "form_consent_checkbox", "form_combobox_choices", "form_fremium_emails", "form_resource_form_cta", "form_custom_thank_you"];

      if(img_elem.length){
        if(img_elem.is(':checked')){
          showHideLoop(form_fields, "hide");
        }
        img_elem.click(function() {
          showHideLoop(form_fields, "hide");
        });
      }
      if(form_elem.length){
        if(form_elem.is(':checked')){
          showHideLoop(form_fields, "show");
        }
        form_elem.click(function() {
          showHideLoop(form_fields, "show");
        });
      }
    }
    function showHideLoop(form_fields, visibility){
      for (let i = 0; i < form_fields.length; i++) {
        if(visibility == "show")
          $('div[data-name="'+form_fields[i]+'"]').show();
        else{
          $('div[data-name="'+form_fields[i]+'"]').hide();

          if('form_reporting_title' == form_fields[i]){
            $('div[data-name="'+form_fields[i]+'"]').find("input").val('Reporting Title');
          }
          if('form_co_code' == form_fields[i]){
            $('div[data-name="'+form_fields[i]+'"]').find("input").val('CO Code');
          }
          if('form_select_form' == form_fields[i]){
            $('div[data-name="'+form_fields[i]+'"]').find("select").append('<option value="0" data-select2-id="0">Select Form</option>');
          }
          if('form_persona' == form_fields[i]){
            $('div[data-name="'+form_fields[i]+'"]').find("select").val('technology_leadership').trigger('change.select2');
          }
          if('form_initiative' == form_fields[i]){
            $('div[data-name="'+form_fields[i]+'"]').find("select").val('sap_testing').trigger('change.select2');
          }
        }
      }
    }
    ImageOrForm();

    
  });
})(jQuery);