$(document).ready(function() {

  $('#verify').click(function() {

    console.log('clicked');
    var vno = $('#number').val();
    console.log(vno);
    $.get(
      '../admin/validateDocuments.php', {
        no:vno
      },
      function(response) {
        if (response.status == "TRUE") {
            alert("SuccesFully Verified !");
            window.location = "../admin/verifyDocuments.php";
        } else {


        }
      },
      'json'
    );


  });
});
