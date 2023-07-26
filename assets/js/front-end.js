(function ($) {

    $(document).ready(function () {

        $('#pj_MEM_DIR_state_select').on('change', function () { 

            var state = $(this).val();

            let data = "action=pj_MEM_DIR_state_filter&ajax_nonce="+ajax_object.ajax_nonce+"&stateOrProvince="+state+"&ajax_request=true";
            run_directory_request(data);
        });

         $('#pj_MEM_DIR_sourceCode_search').on('change', function () { 

            var code = $(this).val();

            let data = "action=pj_MEM_DIR_code_filter&ajax_nonce="+ajax_object.ajax_nonce+"&codes="+code+"&ajax_request=true";
            run_directory_request(data);
        });
       
    });
    function run_directory_request(data){

         $.ajax({

                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function (response) {
                    //  console.log(response);
                    $('#pj_MEM_DIR_membership_container').html(response);
                }

              });   
    }
  

})(jQuery);