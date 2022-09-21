<script src="{{ url('mazer/assets/vendors/choices.js/choices.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.slim.js"
    integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script src="{{ url('mazer/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ url('mazer/assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ url('mazer/assets/js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<script src="{{ url('mazer/assets/vendors/toastify/toastify.js') }}"></script>
<script src="{{ url('mazer/assets/js/extensions/toastify.js') }}"></script>

<script src="{{ url('mazer/assets/vendors/summernote/summernote-lite.min.js') }}"></script>
<script>
    $('#summernote').summernote({
        tabsize: 2,
        height: 120,
    })

    $('#summernote1').summernote({
        tabsize: 2,
        height: 120,
    })

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

@yield('script')
