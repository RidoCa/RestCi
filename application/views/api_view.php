<html>
<head>
    <title>CURD REST API in Codeigniter</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Perusahaan Emas PT Sinar Jaya</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">Data Emas Harian</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Tambah</button>
                        <a class="btn btn-info btn-xs" href="<?= site_url('login/logout') ?>">Logout</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Jenis Emas</th>
                            <th>Harga/Gram</th>
                            <th>Tanggal Penjualan</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Data Emas</h4>
                </div>
                <div class="modal-body">
                    <label>Jenis emas</label>
                    <input type="text" name="jenis_emas" id="jenis_emas" class="form-control" />
                    <span id="jenis_emas" class="text-danger"></span>
                    <br />
                    <label>Tanggal Penjualan Emas</label>
                    <input type="date" name="tanggal_penjualan" id="tanggal_penjualan" class="form-control" />
                    <span id="tanggal_penjualan" class="text-danger"></span>
                    <br />
                    <label>Harga emas</label>
                    <input type="text" name="harga_gram" id="harga_gram" class="form-control" />
                    <span id="harga_gram" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_penjualan" id="id_penjualan" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    
    function fetch_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data:{data_action:'fetch_all'},
            success:function(data)
            {
                $('tbody').html(data);
            }
        });
    }

    fetch_data();

    $('#add_button').click(function(){
        $('#user_form')[0].reset();
        $('.modal-title').text("Add User");
        $('#action').val('Add');
        $('#data_action').val("Insert");
        $('#userModal').modal('show');
        
    });

    $(document).on('submit', '#user_form', function(event){
        event.preventDefault();
        $.ajax({
            url:"<?php echo base_url() . 'test_api/action' ?>",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                if(data.success)
                {
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Inserted</div>');
                    }
                }

                if(data.error)
                {
                    $('#jenis_emas_error').html(data.jenis_emas_error);
                    $('#tanggal_penjualan_error').html(data.tanggal_penjualan);
                    $('#harga_gram_error').html(data.harga_gram);
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var id_penjualan = $(this).attr('id');
        $.ajax({
            url:"<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data:{id_penjualan:id_penjualan, data_action:'fetch_single'},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('.modal-title').text('Edit User');
                $('#jenis_emas').val(data.jenis_emas);
                $('#tanggal_penjualan').val(data.tanggal_penjualan);
                $('#harga_gram').val(data.harga_gram);
                $('#id_penjualan').val(id_penjualan);
                $('#action').val('Edit');
                $('#data_action').val('Edit');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var id_penjualan = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url:"<?php echo base_url(); ?>test_api/action",
                method:"POST",
                data:{id_penjualan:id_penjualan, data_action:'Delete'},
                dataType:"JSON",
                success:function(data)
                {
                    if(data.success)
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Deleted</div>');
                        fetch_data();
                    }
                }
            })
        }
    });
    
});
</script>