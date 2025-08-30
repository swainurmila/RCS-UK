<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>
                    document.write(new Date().getFullYear())
                </script>
                {{__('messages.CooperativesDepartment')}}
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                {{__('messages.Developedby')}} <a href="https://oasystspl.com/" target="_blank" class="designed-link">{{__('messages.Oasys')}}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
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

<!-- App JS (Custom scripts) -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<!-- DataTables Buttons CSS -->
<style>
    /* Custom Button Styling to Match Your Theme */
    .dt-button.btn-outline-default {
        background: #f2f2fe;
        border: 1px solid #3f51b5;
        color: #3f51b5;
        border-radius: 100px;
        padding: 8px 15px;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    .dt-button.btn-outline-default:hover {
        background: #3f51b5;
        color: white;
    }

    .dt-button.btn-outline-default i {
        font-size: 14px;
        margin-right: 5px;
    }
</style>
