<!-- Bootstrap core JavaScript-->



<script src="{{ asset('admin-asset/vendor/jquery/jquery.min.js') }}"></script>



<script src="{{ asset('admin-asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>











<!-- dropify -->



<script src="{{ asset('js/dropify/dropify.js') }}"></script>







<!-- Core plugin JavaScript-->



<script src="{{ asset('admin-asset/vendor/jquery-easing/jquery.easing.min.js') }}"></script>







<!-- Page level plugins -->



<script src="{{ asset('admin-asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>



<script src="{{ asset('admin-asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>







<!-- Page level custom scripts -->

<script src="{{ asset('js/parsley/parsley.min.js') }}"></script>

<script src="{{ asset('admin-asset/js/demo/datatables-demo.js') }}"></script>











<!-- Custom scripts for all pages-->



<script src="{{ asset('admin-asset/js/sb-admin-2.min.js') }}"></script>



<script src="{{ asset('admin-asset/vendor/select2/js/select2.min.js') }}"></script>



<!-- TinyMCE -->



<script src="{{ asset('admin-asset/js/tinymce/tiny_old.min.js') }}"></script>



{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.3/tinymce.min.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.3/themes/silver/theme.min.js"></script>  --}}



{{--  <script src="{{ asset('admin-asset/js/tinymce/themes/modern/theme.min.js') }}"></script> --}}







<script>



    tinymce.init({



        selector: '.tinymce',



        plugins: "{{ config('constants.tiny_plugins') }}",



        toolbar: "{{ config('constants.tiny_toolbar') }}",



        contextmenu: "{{ config('constants.tiny_contextmenu') }}",



        autoresize_bottom_margin: 0,



        image_advtab: true,



        menubar: false,



    });



</script>







<!-- Custom -->



<script src="{{ asset('admin-asset/js/custom.js') }}?v={{ config('constants.asset_version') }}"></script>
