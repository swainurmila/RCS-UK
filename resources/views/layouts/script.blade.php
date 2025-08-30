<!-- jQuery and Bootstrap -->
<!-- jQuery (Core Dependency) -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Bundle (with Popper) -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- UI/UX Libraries -->
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<!-- Counter-Up -->
<script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>

<!-- Datepickers -->
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/datepicker/datepicker.min.js') }}"></script>

    <!-- date picker -->
    <script src={{ asset(path:'assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}></script>
    <script src={{ asset(path:'assets/libs/select2/js/select2.min.js') }}></script>
    <script src={{ asset(path:'assets/libs/spectrum-colorpicker2/spectrum.min.js') }}></script>
    <script src={{ asset(path:'assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}></script>
    <script src={{ asset(path:'assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}></script>
    <script src={{ asset(path:'assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}></script>
    <script src={{ asset(path:'assets/libs/@chenfengyuan/datepicker/datepicker.min.js') }}></script>

      <!-- init js -->
    <script src={{ asset(path:'assets/js/pages/form-advanced.init.js') }}></script>
 
 


<!-- FontAwesome Initialization -->
<script src="{{ asset('assets/js/pages/fontawesome.init.js') }}"></script>

<!-- DataTables Core -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- DataTables Buttons Dependencies -->
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>

<!-- DataTables Buttons -->
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- DataTables Responsive -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable Initialization (Must load last!) -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<!-- apex chart init -->
<script src="{{ asset('assets/js/pages/apexcharts.init.js') }}"></script>

<!-- Chart Js -->
<script src="{{ asset('assets/libs/chart.js/Chart.bundle.min.js') }}"></script>
<!-- Chart js init -->
<script src="{{ asset('assets/js/pages/chartjs.init.js') }}"></script>



<!-- App JS (Custom scripts) -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
    integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<!-- Then jQuery Validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

<!-- Then Select2 if you're using it -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    function switchLanguage(lang) {
        $.ajax({
            url: "{{ route('language.switch') }}",
            type: 'POST',
            data: {
                lang: lang,
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload(); // Reload the page after successful language change
                }
            },
            error: function(xhr) {
                console.error("Error changing language:", xhr.responseText);
            }
        });
    }

    function viewAttachment(url) {
        window.open(url, '_blank', 'width=1000,height=800,noopener,noreferrer');
    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@yield('js')
