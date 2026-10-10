
<!--plugins-->
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>

@auth
    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/easyPieChart/jquery.easypiechart.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/component-popovers-tooltips.js') }}"></script>

    <!--app-->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
@endauth
<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>

{{--<script>--}}
{{--    new PerfectScrollbar(".best-product")--}}
{{--    new PerfectScrollbar(".top-sellers-list")--}}
{{--</script>--}}

@stack('scripts')
