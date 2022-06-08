  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- MDBootstrap Datatables  -->
  <script type="text/javascript" src="js/addons/datatables.min.js"></script>
  <!-- Initializations -->
  <script type="text/javascript">
    // Animations initialization
    new WOW().init();

    $(document).ready(function () {
        $('#dtBasicExample').DataTable();
        
        $('.dataTables_length').addClass('bs-select');

        $("input[name='podKategorieProdukt']").on("change",function () {
          $("#parametry").show();
          var subCategoryId = $('input[name=podKategorieProdukt]:checked', '#managerForm').val();
          $.ajax({
              url: "param-load.php<?php if(!empty($id)) { echo "?id=" . $id; } ?>",
              type: "POST",
              data: "subCategoryId="+subCategoryId,
              success: function (response) {
                  console.log(response);
                  $('#parametry').html(response);
              },
          });
        });
    });

  </script>
</body>

</html>