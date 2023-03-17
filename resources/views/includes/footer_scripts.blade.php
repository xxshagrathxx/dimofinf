  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('template/vendors/base/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="{{ asset('template/vendors/chart.js/Chart.min.js') }}"></script>
  {{-- <script src="{{ ('template/vendors/datatables.net/jquery.dataTables.js') }}"></script> --}}
  {{-- <script src="{{ ('template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script> --}}
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('template/js/off-canvas.js') }}"></script>
  <script src="{{ asset('template/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('template/js/template.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('template/js/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('template/js/dashboard.js') }}"></script>
  <script src="{{ asset('template/js/data-table.js') }}"></script>
  <script src="{{ asset('template/js/dataTables.bootstrap4.js') }}"></script>
  <!-- End custom js for this page-->

  {{-- <script src="{{ asset('template/js/jquery.cookie.js') }}" type="text/javascript"></script> --}}


  <script src="{{ asset('js/is_number_key.js') }}" type="text/javascript"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/sweet_alert_delete.js') }}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
  @if(Session::has('message'))
  var type = "{{ Session::get('alert-type','info') }}";
  // toastr.options.positionClass = 'toast-top-left';
  switch(type){
     case 'info':
     toastr.info(" {{ Session::get('message') }} ");
     break;

     case 'success':
     toastr.success(" {{ Session::get('message') }} ");
     break;

     case 'warning':
     toastr.warning(" {{ Session::get('message') }} ");
     break;

     case 'error':
     toastr.error(" {{ Session::get('message') }} ");
     break;
  }
  @endif
</script>
