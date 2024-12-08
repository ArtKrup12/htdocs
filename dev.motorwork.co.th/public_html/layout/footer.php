</div>
  <!-- /.content-wrapper -->
<style>
    @media (max-width: 576px) {
        .main-footer {
            font-size: 10px; /* ขนาดตัวอักษรลดลงเมื่อหน้าจอเล็กกว่า 576px */
        }

        .main-footer .float-right {
            font-size: 10px; /* ขนาดตัวอักษรสำหรับ 'Version' ลดลง */
        }

        .main-footer span {
            font-size: 10px; /* ขนาดตัวอักษรสำหรับชื่อบริษัทลดลง */
        }
    }
</style>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 0.1 BETA
    </div>
      Copyright © 2024 Edited by <span style="color: #9B111E">MOTORWORK CO.,LTD.</span> | All Rights Reserved
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/moment/moment.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/tagsinput.js?v=1"></script>
<script src="assets/plugins/select2/js/select2.full.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
<script>
  $(document).ready(function () {
    //$('.sidebar-menu').tree();
    //$('.select2').select2();
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })


  })
</script>
<script>
  // $(function () {
  //   $('#example1').DataTable()
  //   $('#example2').DataTable({
  //     'paging'      : true,
  //     'lengthChange': false,
  //     'searching'   : false,
  //     'ordering'    : true,
  //     'info'        : true,
  //     'autoWidth'   : false
  //   })
  // })
</script>
