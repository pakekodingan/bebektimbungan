<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datatable Serverside Codeigniter</title>
    <link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head> 
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

            <h3>BEBEK TIMBUNGAN MASTERBARANG</h3>
            <br />
            
            <table id="table" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>PCode</th>
                        <th>Nama Langkap</th>
                        <th>Image</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
        <br><br>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-edit" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg">
        <div class="modal-content">
          <form id="form-masterbarang" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Master Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <label>PCode</label>
                <input type="text" name="pcode" id="pcode" class="form-control form-control-sm" readonly="">
              </div>
              <div class="form-group">
                <label for="">Nama Langkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control form-control-sm" required="">
              </div>
              <div class="form-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" class="form-control form-control-sm" required="">
                 
                </select>
              </div>
              <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm" required=""></textarea>
              </div>
              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="text" name="harga" id="harga" class="form-control form-control-sm" required="">
              </div>
              <div class="form-group">
                <label for="gambar">Upload Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control form-control-sm" >
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" >Close</button>
            <button type="submit" class="btn btn-primary btn-lg" id="btn-save">Save</button>
          </div>
          </form>
        </div>
      </div>
    </div>
 
<script src="<?php echo base_url('assets/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sh{a384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 
 
<script type="text/javascript">
   
    $(document).ready(function() {
        getData();
        
        $("#form-masterbarang").submit(function(e){
            e.preventDefault();
            $.ajax({
                url : "<?php echo site_url();  ?>/masterbarang/save",
                type : "POST",
                data : new FormData(this),
                contentType : false,
                processData : false,
                beforeSend : function(){
                    $("#btn-save").html("Process..");
                },
                success : function(res){
                    var data = JSON.parse(res);

                    if(data.message == 'success'){
                        alert('Sukses');
                        getData();
                    }else{
                        alert('Gagal');
                    }
                    $("#btn-save").html("Save");
                },
                error : function(e){
                    alert("error : "+e);
                    $("#btn-save").html("Save");
                }
            });
        });
    });

    function getData(){
         var table;
            table = $('#table').DataTable({ 
            "processing": true, 
            "destroy": true,
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('masterbarang/get_data_masterbarang')?>",
                "type": "POST"
            },
 
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });
    }

    function edit(pcode,nama_lengkap,harga,image,kdsubkategori,deskripsi){ 
        $("#pcode").val(pcode);
        $("#nama_lengkap").val(nama_lengkap);
        $("#harga").val(harga);
        $("#image").val(image);
        $("#deskripsi").val(deskripsi);
        $("#gambar").val("");
        var Kategori = <?php echo json_encode($Kategori); ?>;

        var opt = "<option value=''>Pilih</option>";
        $.each(Kategori,function(key,val){
            var selected = val.KdSubKategori == kdsubkategori ? "selected" : "";
            opt += "<option value='"+val.KdSubKategori+"' "+selected+">"+val.NamaSubKategori+"</option>";
        });
        $("#kategori").html(opt);
        $("#modal-edit").modal('show');
    }
 
</script>
 
</body>
</html>