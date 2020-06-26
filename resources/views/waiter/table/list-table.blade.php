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
                      <input type="hidden" name="tableId" id="tableId">
                      <input type="text" id="tableName" name="tableName" class="form-control" placeholder="name of the table">
                    </div>
                    <div class="form-group">
                      <label>Table Code</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">TBL -</span>
                        </div>
                        <input type="text" id="tableCode" name="tableCode" class="form-control" placeholder="code of the table">
                      </div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="showQRCode">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">QR Codes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body justify-content-center">
        <div id="qrcodes" class="p-4 rounded bg-white d-inline-block"></div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal animate__animated animate__tada" tabindex="-1" role="dialog" id="showDelete">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body justify-content-center">
        <p>Are you sure to delete this ?</p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-danger" id="deleteData" data-dismiss="modal">Process</button>
      </div>
    </div>
  </div>
</div>

<script defer>
    qrcode = new QRCode(document.getElementById("qrcodes"), {
      width : 200,
      height : 200,
      colorLight : "#ffffff",
    });

    var deleteId;
    $(document).ready(function () {
        // load all data first
        loadData();


        $('#saveData').click(function () {
            if ($('#tableId').val() == '') {
                create($('#formData').serialize());
            } else {
                update($('#tableId').val(), $('#formData').serialize());
            }
        });

        $('#deleteData').click(function () {
            deleteData(deleteId);
        });
    });

    function showQR(tableCode) {
      qrcode.makeCode('TBL-'+tableCode);
      $('#showQRCode').modal('show');
    }

    function showModal(id, tableName, tableCode) {
        $('#tableId').val(id);
        $('#tableName').val(tableName);
        $('#tableCode').val(tableCode);
        $('#showModal').modal('show');
    }

    function showDelete(id) {
      deleteId = id;
      $('#showDelete').modal('show');
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
                $('#thetable').empty();
                $.each(response.data, function (index, val) {
                    $('#thetable').append('<div class="col-3" id="table'+val.id+'"><div class="card card-primary animate__animated animate__fadeIn animate__faster"><div class="card-header"><h4>'+ val.tableName +'</h4><div class="card-header-action"><div class="btn-group"><button onclick="showModal('+val.id+',\''+val.tableName+'\',\''+val.tableCode+'\')" class="btn btn-outline-success btn-sm float-right"><i class="fas fa-pencil-alt"></i></button><button onclick="showDelete('+val.id+')" class="btn btn-outline-danger btn-sm float-right"><i class="fa fa-times"></i></button></div></div></div><div class="card-body text-center"><p class="display-3"><i class="fa fa-utensils"></i></p><button onclick="showQR(\''+val.tableCode+'\')" class="btn btn-outline-primary btn-sm">Show QR Code</button></div></div></div>');
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
                $('#thetable').append('<div class="col-3" id="table'+response.data.id+'"><div class="card card-primary animate__animated animate__fadeIn animate__faster"><div class="card-header"><h4>'+ response.data.tableName +'</h4><div class="card-header-action"><button onclick="showModal('+response.data.id+',\''+response.data.tableName+'\',\''+response.data.tableCode+'\')" class="btn btn-outline-success btn-sm float-right">Edit</button></div></div><div class="card-body text-center"><p class="display-3"><i class="fa fa-utensils"></i></p><div class="btn-group"><button onclick="showQR(\''+response.data.tableCode+'\')" class="btn btn-outline-primary btn-sm">Show QR Code</button><button onclick="showDelete('+response.data.id+')" class="btn btn-outline-danger btn-sm float-right"><i class="fa fa-times"></i></button></div></div></div></div>');
                $('#showModal').modal('hide');
                NProgress.done();
			}
		});
    }
    
    function update(id, data) {
        $.ajax({
		    	url: '{{ url("waiter/tables/update") }}/'+ id,
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
                    loadData();
                    $('#formData').trigger('reset');
                    $('#showModal').modal('hide');
                    NProgress.done();
		    	}
		    });
    }

    function deleteData(id) {
      $.ajax({
		  	url: '{{ url("waiter/tables/delete") }}/'+ id,
		  	type: 'GET',
		  	dataType: 'JSON',
        beforeSend: function () {
            NProgress.start();
        },
		  	headers: {
		  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  	},
		  	success: function(response) {
                  $('#table'+id).remove();
                  $('#showModal').modal('hide');
                  loadData();
                  NProgress.done();
		  	}
		  });
    }
</script>