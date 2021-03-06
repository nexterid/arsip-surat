<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="content">            
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-holder">
                    <h1 class="main-title float-left">Master Klasifikasi Surat</h1>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Klasifikasi</li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
		<div class="row">
			<div class="col-xl-12">						
                <div class="card mb-3">
                    <div class="card-header">                    
                        <h3 class='box-title'><button class="btn btn-sm btn-primary" id="btn-tambah"><i class="fa fa-plus"> </i> Tambah Data</button>
                        </h3>
                    </div>                        
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mytable" class="table table-sm table-bordered table-hover display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Klasifikasi</th>
                                        <th>Nama Rumpun</th>                                                                               
                                        <th>Aksi</th>
                                    </tr>
                                </thead>										
                                <tbody> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                        
            </div>														
        </div>	
    </div>			
</div>
<div class="modal fade custom-modal" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="customModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-info" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <h4 class="modal-title" id="exampleModalLabel2">Master Klasifikasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>          
            </div>
            <form class="form-horizontal" method="post" id="form-data" action="#"> 
                <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />  
                <input type="hidden" id="kode" name="kode">               
                <div class="modal-body">               
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Kode Kalsifikasi</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="kode_klasifikasi" name="kode_klasifikasi" placeholder="Kode Klasifikasi">            
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Nama Klasifikasi</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="nama_klasifikasi" name="nama_klasifikasi"  rows="5" placeholder="Nama Klasifikasi"></textarea>          
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Rumpun</label>
                    <div class="col-md-8">
                        <select class="form-control select2" name="rumpun" id="rumpun">
                            <option value="">- Pilih Rumpun -</option>
                        </select>          
                    </div>
                  </div>                
                </div>
                <div class="modal-footer">                   
                    <button class="btn btn-primary" type="button" id="btn-submit">Simpan</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js');?>"></script>
<script>
    $(document).ready(function () {
        ajaxLoad();
    });

    function ajaxLoad() {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#mytable').dataTable({
            "Processing": true,
            "ServerSide": true,
            "iDisplayLength": 25,
            "bDestroy": true,
            "oLanguage": {
                "sSearch": "Search Data :  ",
                "sZeroRecords": "No records to display",
                "sEmptyTable": "No data available in table"
            },
            "ajax": "<?php echo base_url('klasifikasi/getdata'); ?>",
            "columns": [
                {"mData": "no"},                    
                {"width":"10%","mData": "kode"},
                {"mData": "nama"},
                {"mData": "rumpun"},
                {"mData": "aksi"},
            ]
        });
    }

    function getKodeRumpun(kode)
    {
        $.ajax({
            url : "<?php echo site_url('klasifikasi/rumpun'); ?>",
            type: "GET",
            dataType: "JSON",            
            success: function(data)
            {          
                var html = '';
                html +='<option value="">- Pilih Rumpun -</option>';
                for(var i=0; i<data.length; i++){                    
                    html += '<option value="'+data[i].kode_rumpun+'">'+data[i].rumpun+'</option>';
                }  
                $('#rumpun').html(html);
                if(kode){
                     $('#rumpun option[value="'+kode+'"]').attr('selected','selected');
                }
                $(".select2").select2({
                    dropdownParent:  $('#modal-form'),
                    width: '100%'
                });
            },
            
        });      
    }

    $(document).on('click','#btn-tambah',function(e){       
        $('#form-data')[0].reset();
        $('#modal-form').modal('show');         
        $('#btn-submit').text('Simpan');
        document.getElementById('kode_klasifikasi').readOnly = false;
        getKodeRumpun(null);
    });

    $(document).on('click','#btn-update',function(e){
        var kode = $(this).data('kode');
        var nama = $(this).data('nama');
        var rumpun = $(this).data('rumpun');
        $('#form-data')[0].reset();
        $('#modal-form').modal('show'); 
        $('[name="kode"]').val(kode);
        $('[name="kode_klasifikasi"]').val(kode);
        $('[name="nama_klasifikasi"]').val(nama);
        getKodeRumpun(rumpun);
        document.getElementById('kode_klasifikasi').readOnly = true;
        $('#btn-submit').text('Update');
    });

    $(document).on('click','#btn-submit',function(e){
        var formdata = $('#form-data').serialize();
        $('#btn-submit').prop('disabled', true);
        $('#btn-submit').text('... Proses Simpan');
        $.ajax({
            url : "<?php echo site_url('klasifikasi/simpan'); ?>",
            type:"POST",
            dataType: "json",
            data : formdata,
            success: function(response)
            {    
                var token = response.token;
                $('#txt_csrfname').val(token);      
                $('#btn-submit').prop('disabled', false);
                $('#btn-submit').text('Simpan');
                $('#modal-form').modal('hide');
                ajaxLoad();
            }
        });   
    });

</script>
<?= $this->endSection() ?>