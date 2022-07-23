<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
@yield('vendor-script')
<script src="dist/js/adminlte.js"></script>
<script src="{!! asset('/dist/js/pages/scp-28.js')!!}"></script>
@yield('page-script')