
<!-- Vue App JS -->
<script>
    var ajax_url = '{{  route('ajax')  }}';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script src="{{ asset('admin-asset/js/tinymce/tiny_old.min.js') }}"></script>
<script src="{{ asset('js/wow/wow.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.mcustomscrollbar.min.js') }}"></script>

<script type="text/javascript">
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/bootstrap/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/parsley/parsley.min.js') }}"></script>
<script src="{{ asset('js/noty/noty.min.js') }}"></script>
@include('frontend.partials.flash-messages')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

    })
</script>
@auth
@if(auth()->check() && auth()->user()->is_company == 0)
<script>
    $(function () {
        var cookieValue = $.cookie("remember-popup");

        if(cookieValue != 'true'){
            window.setTimeout(function(){
                $("#alertmodal").modal('show');
            },5000);
        }

        $('#remember-later').click(function () {
            $.cookie("remember-popup", true, { expires : 1 });
            $("#alertmodal").modal('hide');
        })
    })
</script>

@endif
@endauth
