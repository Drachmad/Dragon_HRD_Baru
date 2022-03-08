<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url()?>assets/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?php echo base_url()?>assets/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?php echo base_url()?>assets/js/demo/chart-area-demo.js"></script>
<script src="<?php echo base_url()?>assets/js/demo/chart-pie-demo.js"></script>


<script src="<?php echo base_url()?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script  src="<?php echo base_url()?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>






<!-- <script  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script  src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script  src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script> 
<script  src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script  src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script  src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
-->



<script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable();
      } );
</script> 
<!--  
<script type="text/javascript">
$(document).ready(function() {
  $('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
  } );
} );
</script>  -->

<script type="text/javascript">
  jQuery(function($) {
      $('body').on('click', '#selectall', function() {
            $('.singlechkbox').prop('checked', this.checked);
      });

      $('body').on('click', '.singlechkbox', function() {
          if($(".singlechkbox").length == $(".singlechkbox:checked").length) {
              $("#selectall").prop("checked", "checked");
          } else {
              $("#selectall").removeAttr("checked");
          }

      });
  });
</script>




</body></html>