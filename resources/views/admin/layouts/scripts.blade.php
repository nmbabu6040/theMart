<!-- core:js -->
<script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>
<!-- endinject -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- plugin js for this page -->
<script src="{{ asset('backend/assets/vendors/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/jquery.flot/jquery.flot.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/jquery.flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
<!-- end plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/template.js') }}"></script>
<!-- endinject -->
<!-- custom js for this page -->
<script src="{{ asset('backend/assets/js/dashboard.js') }}"></script>
<script src="{{ asset('backend/assets/js/datepicker.js') }}"></script>
<!-- end custom js for this page -->
@stack('scripts')
