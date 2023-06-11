(function ($) {

    $(document).ready(function () {

        $('#pj_ea_state_select').on('change', function () { 

            var state = $(this).val();

            let data = "action=pj_ea_state_filter&ajax_nonce="+ajax_object.ajax_nonce+"&stateOrProvince="+state+"&ajax_request=true";
        
        //    console.log(data);
              $.ajax({

                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function (response) {
                    //  console.log(response);
                    $('#pj_ea_membership_directory').html(response);
                }

              });   
        });
       
    });
  

})(jQuery);