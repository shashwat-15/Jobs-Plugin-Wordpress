jQuery(document).ready(function($){

  let ajax_url = plugin_job.ajax_url;

  // Get the modal
  let modal = $("#myModal");

  // Get the anchor tag that opens the modal
  let link = $(".link");

  link.on('click', function() {

      let selected_job_id = $(this).attr("id");

      let data = {
        'action': 'selectedJob',
        'selected_job_id': selected_job_id
      };

      $.ajax({
        url: ajax_url,
        type: 'post',
        data: data,
        dataType: 'json',
        success: function(response){
          createModalRows(response);
        }
      });
  });
  

  function createModalRows(response) {
    
    let position = response.Position;
    let type = response.Type;
    let description = response.Description;
    let wage = response.Wage;
    let email = response.Email;
    let postingDate = response.PostingDate

    $('#position').text(position);
    $('#type').text(type);
    $('#description').text(description);
    $('#wage').text(wage);
    $('#email').text(email);
    $('#posting_date').text(postingDate);

    modal.css("display", "block");
  }

  // Get the <span> element that closes the modal
  let span = $(".close");

  // When the user clicks on <span> (x), close the modal
    span.on('click', function() {
      modal.css("display", "none");
  });

  // When the user clicks anywhere outside of the modal, close it
  $(window).on('click', function(event) {
    if ($(event.target).attr("id") == "myModal") {
      modal.css("display", "none");
    }
  });

});