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
                        <th>Title</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Created At</th>
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
            ajax: "{{ route('news.index') }}",
            columns: [
                {
                    data: 'title',
                    name: 'news.title'
                },
                {
                    data: 'name',
                    name: 'categories.name'
                },
                {
                    data: 'created_at',
                    name: 'news.created_at',
                    render : function (data,full ) {
                    return moment(data).format('DD-MMM-YYYY');
                    }
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
                    <label for="category"> Category</label>
                    <div class="form-group">
                        <select class="form-select" name="category_id" id="category">
                            <option selected disabled>Select Category</option>
                        </select>
                    </div>

                    <label for="title"> Title</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="title" name="title" class="form-control" placeholder="Title" autocomplete="off" required>
                        </div>
                    </div>

                    <label for="detail"> Detail</label>
                    <div class="form-group">
                        <div id="summernote"></div>
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
                    <label for="category"> Category</label>
                    <div class="form-group">
                        <select class="form-select" name="category_id" id="category">
                            <option selected disabled>Select Category</option>
                        </select>
                    </div>

                    <label for="title"> Title</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="title" name="title" class="form-control" placeholder="Title" autocomplete="off" value="${data.title}">
                        </div>
                    </div>

                    <label for="detail"> Detail</label>
                    <div class="form-group">
                        <div id="summernote"></div>
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
                            <th>Title</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <td></td>
                    </tr>
                </tfoot>
                </table>
            </div>
        `)
    }

    function addPage()
    {
        getCategory()
        $('#add-data').slideUp()
        let html = addComponent();

        $('select').select2({ width: '100%', placeholder: "Select an Option", allowClear: true });
        $('.card-body').fadeOut()
        $('.card-body').html(html)
        $('.card-body').fadeIn()
        $('#summernote').summernote({
            tabsize: 2,
            height: 120,
        })
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
        getCategoryByValue(data.category_id)
        $('#add-data').slideUp()
        let html = editComponent(data);
        $('.card-body').fadeOut()
        $('.card-body').html(html)
        $('.card-body').fadeIn()
        $('#summernote').summernote({
            tabsize: 2,
            height: 120,
        })
        $("#summernote").summernote("code", `${data.detail}`);
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
            url: '{{route('news.store')}}',
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'category_id': $('#category').select2().val(),
                'title': $('#title').val(),
                'detail': $('#summernote').summernote('code'),
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

        $.ajax({
            url: `{{route('news.update','id')}}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': id,
                'category_id': $('#category').select2().val(),
                'title': $('#title').val(),
                'detail': $('#summernote').summernote('code'),
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
            url: `{{route('news.destroy','id')}}`,
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

    function getCategory()
    {
        $.ajax({
            url: `{{route('news.create')}}`,
            type: "GET",
            dataType: "json",
            success: function(data) {
                data.data.forEach(item => {
                    $('#category').append(`<option value="${item.id}">${item.name}</option>`)
                });
                $('#category').addClass('choices')
                initSelect()
            }
        });
    }

    function getCategoryByValue(value)
    {
        $.ajax({
            url: `{{route('news.create')}}`,
            type: "GET",
            dataType: "json",
            success: function(data) {
                let html
                data.data.forEach(item => {
                    html += `<option value="${item.id}">${item.name}</option>`
                });
                $('#category').html(html)

                $('#category').select2().val(value).trigger('change.select2');
                initSelect()
            }
        });
    }

    function initSelect()
    {
        $('#category').select2({
            placeholder: 'Select an Category',
        });
    }
</script>
@endsection
