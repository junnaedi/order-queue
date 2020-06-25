@include('layouts.waiter.head')
@include('layouts.waiter.header')
@include('layouts.waiter.sidebar')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tables</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">List Table</div>
            </div>
        </div>

        <div class="section-body">
            <button onclick="showModal()" class="btn btn-outline-primary float-right">Add new</button>
            <h2 class="section-title">List all Tables</h2>
            <p class="section-lead">This page is just an example for you to create your own page.</p>
            <div class="row" id="thetable">
                <!-- table goes here -->
            </div>
        </div>
    </section>
</div>

@include('layouts.waiter.footer')

<div class="modal fade" tabindex="-1" role="dialog" id="showModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Table</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formData" method="post" autocomplete="off">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <label>Table Name</label>
                      <input type="text" id="tableName" name="tableName" class="form-control" placeholder="name of the table">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="saveData" class="btn btn-outline-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script defer>
    $(document).ready(function () {
        // load all data first
        loadData();

        $('#saveData').click(function () {
            create($('#formData').serialize());
        });
    });

    function showModal(id, data) {
        $('#tableName').val(data);
        $('#showModal').modal('show');
    }

    function loadData(datatoload) {
        $.ajax({
			url: '{{ url("waiter/tables/load_data") }}',
			type: 'POST',
			dataType: 'JSON',
            beforeSend: function () {
                NProgress.start();
            },
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
                $.each(response.data, function (index, val) {
                    $('#thetable').append('<div class="col-3"><div class="card card-primary animate__animated animate__fadeIn animate__faster"><div class="card-header"><h4>'+ val.tableName +'</h4><div class="card-header-action"><button onclick="showModal('+val.id+',\''+val.tableName+'\')" class="btn btn-outline-success btn-sm float-right">Edit</button></div></div><div class="card-body text-center"><button class="btn btn-outline-primary btn-sm">Generate QR Code</button></div></div></div>');
                });
                NProgress.done();
			}
		});
    }

    function create(data) {
        $.ajax({
			url: '{{ url("waiter/tables/insert") }}',
			type: 'POST',
			dataType: 'JSON',
            data: data,
            beforeSend: function () {
                NProgress.start();
            },
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
                $('#formData').trigger('reset');
                $('#thetable').append('<div class="col-3"><div class="card animate__animated animate__fadeIn animate__faster"><div class="card-header"><h4>'+ response.data.tableName +'</h4></div><div class="card-body text-center"><button class="btn btn-outline-primary btn-sm">Generate QR Code</button></div></div></div>');
                $('#showModal').modal('hide');
                NProgress.done();
			}
		});
    }
</script>