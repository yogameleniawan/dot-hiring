@extends('admin.layouts.app')
@section('css')

@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <button id="add-data" type="button" onclick="addPage()" class="btn btn-success mt-4">Add Data</button>
    </div>
    <div class="card-body">
        <div class="table-responsive " style="margin-top:15px;">
            <table id="data_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" id="modal-content">

        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

    let table;
    const initializeTable = () => {
        table = $('#data_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('categories.index') }}",
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        return table;
    }

    $(document).ready(function () {
        initializeTable()
        $('#data_table tfoot th').each(function () {
            var title = $('#data_table thead th').eq($(this).index()).text();
            $(this).html('<input type="text" class="form-control" placeholder="Search ' + title +
                '" />');
        });
        $('tfoot').each(function () {
            $(this).insertAfter($(this).siblings('thead'));
        });

        table.columns().eq(0).each(function (colIdx) {
            $('input', table.column(colIdx).footer()).on('keyup change', function () {
                table
                    .column(colIdx)
                    .search(this.value)
                    .draw();
            });
        });
    });

</script>
<script>

    let viewData;
    function formatDate(date){
        let tanggal = moment(date, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
        return tanggal;
    }

    const addComponent = () => {
        return (
            `
            <form id="form-data" enctype="multipart/form-data">

                    <label for="name"> Name</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name" autocomplete="off" required>
                        </div>
                    </div>

                    <a id="btn-cancel"class="btn btn-light-secondary" onclick="tablePage()">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Kembali</span>
                    </a>
                    <div id="btn-loader" class="loader d-none"></div>
                    <a id="btn-action" onclick="addData()" class="btn btn-success ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" >Simpan</span>
                    </a>
                </form>
            `
        )
    }

    const editComponent = (data) => {
        return (
            `
            <form id="form-data" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="${data.id}">
                    <label for="name"> Name</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name" autocomplete="off" value="${data.name}">
                        </div>
                    </div>
                    <a id="btn-cancel"class="btn btn-light-secondary" onclick="tablePage()">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Kembali</span>
                    </a>
                    <div id="btn-loader" class="loader d-none"></div>
                    <a id="btn-action" onclick="editData('${data.id}')" class="btn btn-success ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" >Update</span>
                    </a>
                </form>
            `
        )
    }

    const tableComponent = () => {
        return (`
            <div class="table-responsive " style="margin-top:15px;">
                <table id="data_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        `)
    }

    function addPage()
    {
        $('#add-data').slideUp()
        let html = addComponent();
        $('.card-body').fadeOut()
        $('.card-body').html(html)
        $('.card-body').fadeIn()
    }

    function tablePage()
    {
        $('#add-data').slideDown()
        let html = tableComponent();
        $('.card-body').fadeOut()
        $('.card-body').html(html)
        initializeTable()
        $('.card-body').fadeIn()
    }

    function editPage(data)
    {
        $('#add-data').slideUp()
        let html = editComponent(data);
        $('.card-body').fadeOut()
        $('.card-body').html(html)
        $('.card-body').fadeIn()
    }


    function deleteModal(data)
    {
        let html = `<div class="modal-body">
                <div class="row">
                    <div class="col-md-12"><h3>Delete Data</h3></div>
                    <div class="col-md-12"><p>Are you sure to delete this data?</p></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <div id="btn-loader" class="loader d-none"></div>
                <button id="btn-action" onclick="deleteData(${data.id})" class="btn btn-danger ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block" >Delete</span>
                </button>
            </div>`
        $('#modal-content').html(html)
    }

    function addData()
    {
        $('#btn-loader').removeClass('d-none')
        $('#btn-action').addClass('d-none')
        $('#btn-cancel').addClass('d-none')
        let data = new FormData($('#form-data')[0]);
        $.ajax({
            url: '{{route('categories.store')}}',
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'name': $('#name').val(),
            },
            statusCode: {
                500: function(response) {
                    console.log(response)
                    Toastify({
                        text: 'Data add unsuccessful',
                        backgroundColor: '#d74d4d',
                    }).showToast();
                    $('#btn-loader').addClass('d-none')
                    $('#btn-cancel').removeClass('d-none')
                    $('#btn-action').removeClass('d-none')
                },
            },
            success: function(data) {
                $("#form-data")[0].reset()
                Toastify({
                    text: 'Data add successful',
                    backgroundColor: '#435ebe',
                }).showToast();
                $('#btn-loader').addClass('d-none')
                $('#btn-cancel').addClass('d-none')
                tablePage()
            }
        });
    }

    function editData(id)
    {
        $('#btn-loader').removeClass('d-none')
        $('#btn-action').addClass('d-none')
        $('#btn-cancel').addClass('d-none')
        let data = new FormData($('#form-data')[0]);
        data.append('_method', 'PATCH');
        $.ajax({
            url: `{{route('categories.update','id')}}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': id,
                'name': $('#name').val(),
                '_method': 'PATCH'
            },
            statusCode: {
                500: function(response) {
                    console.log(response)
                    Toastify({
                        text: 'Data edit unsuccessful',
                        backgroundColor: '#d74d4d',
                    }).showToast();
                    $('#btn-loader').addClass('d-none')
                    $('#btn-cancel').removeClass('d-none')
                    $('#btn-action').removeClass('d-none')
                },
            },
            success: function(data) {
                console.log(data)
                Toastify({
                    text: 'Data edit successful',
                    backgroundColor: '#435ebe',
                }).showToast();
                $('#btn-loader').addClass('d-none')
                $('#btn-cancel').addClass('d-none')
                tablePage()
            }
        });
    }

    function deleteData(id)
    {
        $('#btn-loader').removeClass('d-none')
        $('#btn-action').addClass('d-none')
        $.ajax({
            url: `{{route('categories.destroy','id')}}`,
            type: "DELETE",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': id,
            },
            statusCode: {
                500: function(response) {
                    console.log(response)
                    Toastify({
                        text: 'Data delete unsuccessful',
                        backgroundColor: '#d74d4d',
                    }).showToast();
                    $('#btn-loader').addClass('d-none')
                    $('#btn-action').removeClass('d-none')
                },
            },
            success: function(data) {
                Toastify({
                    text: 'Data delete successful',
                    backgroundColor: '#435ebe',
                }).showToast();
                $('#btn-loader').addClass('d-none')
                tablePage()
                $('#exampleModalCenter').modal('hide');
            }
        });
    }
</script>
@endsection
