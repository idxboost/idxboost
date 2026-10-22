(function($) {

  $(document).ready(function(event){
    var idx_agent_contact_form = $('#idx_agent_contact_form');

    if (idx_agent_contact_form.length>0) {
      idx_agent_contact_form.submit(function(e){
        e.preventDefault();
        $.ajax({
          url: flex_idx_agent_contact.ajaxUrl,
          method: "POST",
          data: idx_agent_contact_form.serialize(),
          dataType: "json",
            success: function(response) {
              console.log(response);
              if (response.success) {
                sweetAlert(word_translate.email_sent, word_translate.your_email_was_sent_succesfully, "success");
              }else{
                sweetAlert('Error','', "error");
              }
            }
          });

      });

    }
  });


})(jQuery);

