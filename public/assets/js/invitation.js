jQuery(document).ready(function() {
  $("#sms-send").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data("student-id");
    var url = "/apprenant/" + id + "/invitation";

    fetch(url, { method: "POST" });
  });
});
