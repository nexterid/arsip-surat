<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="content">            
    <div class="container-fluid">					
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-holder">
                    <h1 class="main-title float-left" id="nama_ruang">Arsip Surat Masuk </h1>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <?php echo anchor('home', 'Dashboard'); ?>
                        </li>
                        <li class="breadcrumb-item">Surat</li>
                        <li class="breadcrumb-item active">Masuk</li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
			<div class="col-xl-12">						
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white"> 
                        <div class="row">                            
                            <div class="col-sm-8">                                
                                <div class="form-group row">
                                    <label for="tahun" class="col-form-label">Bulan </label> 
                                    <div class="col-sm-4">                                    
                                        
                                        <select name="bulan" id="bulan" class="form-control" onchange="ajaxLoad()">
                                            <?php 
                                                $start = strtotime('first day of this month');
                                                for ($i = 0; $i <= 12; ++$i) {
                                                    $time = strtotime(sprintf('-%d months', $i), $start);
                                                    $value = date('Y-m-d', $time);
                                                    $label = date('Y-m', $time);
                                                    echo "<option value='$value'>".tgl_lengkap($label)."</option>";
                                                }  
                                            ?>
                                        </select>
                                    </div>                                
                                </div>
                            </div>       
                            <div class="col-lg-4">
                                <input type='text' name="search" class="form-control"  id="searchInput" placeholder="Cari..."/>                        
                            </div>               
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table width="100%" id="mytable" class="table table-sm table-bordered table-hover display">
                                <thead>
                                    <tr bgcolor="#E5E5E5" style="height:45px;">
                                        <th>No Agenda</th>
                                        <th>Tgl Agenda</th>
                                        <th>Asal Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>Tgl Surat</th>
                                        <th>Isi Surat</th>
                                        <th>Sifat Surat</th>
                                        <th>Isi Disposisi Direktur</th>
                                        <th>Disposisi Ke Wadir</th>
                                        <th>Disposisi Wadir ke Unit</th>
                                        <th>File Lampiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>										
                                <tbody></tbody>
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
                <h4 class="modal-title" id="exampleModalLabel2">Disposisi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>          
            </div>
            <form class="form-horizontal" method="post" id="form-data" action="#"> 
            <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <input type="hidden" id="kode_unit" name="kode_unit">  
                <input type="hidden" id="jenis_diposisi" name="jenis_diposisi">     
                <div class="modal-body">               
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Kode Klasifikasi</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" readonly="true" id="kode_klasifikasi" name="kode_klasifikasi" placeholder="Kode Klasifikasi">            
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">No Agenda</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" readonly="true" id="no_agenda" name="no_agenda" placeholder="No Agenda">            
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Tanggal Agenda</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" readonly="true" id="tgl_agenda" name="tgl_agenda" placeholder="Tanggal Agenda">            
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Tanggal Disposisi</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="datepicker" name="tgl_disposisi" placeholder="Tanggal Disposisi">            
                    </div>
                  </div>
                  <div class="form-group row" id="disposisi_kepada">
                    <label class="col-md-3 col-form-label" for="text-input">Disposisi Kepada</label>
                    <div class="col-md-8">
                        <select class="form-control select2" name="disposisi_ke" id="disposisi_ke" >
                            <option value="">- Disposisi Kepada -</option>
                        </select>            
                    </div>
                  </div>            
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Isi Disposisi</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="isi_disposisi" id="isi_disposisi" rows="5" placeholder="Isi Disposisi"></textarea>           
                    </div>
                  </div>               
                </div>
                <div class="modal-footer">                   
                    <button class="btn btn-primary" type="button" id="btn-save">Simpan</button>
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
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datepicker/locales/bootstrap-datepicker.id.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js');?>"></script>
<script>
    $(document).ready(function () {               
        $('.table').removeAttr('style');
        $("#datepicker").datepicker({
            autoclose: true  
        });
        ajaxLoad();
    });

    $.ajaxSetup({
        header: {
            'X-CSRF-TOKEN' : $('#txt_csrfname').val(),
        }
    });

    function ajaxLoad(){          
        var csrfName = $('#txt_csrfname').attr('name'); 
        var csrfHash = $('#txt_csrfname').val();   
        var bulan =$('#bulan').val();
        $('#mytable').dataTable({
            "Processing": true,
            "ServerSide": true,
            "iDisplayLength": 25,
            "bDestroy": true,
            "sDom" : "<t<p i>>",
            "autoWidth": false,
            "fixedColumns": true,
            "order": [],
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
                "sSearch": "Search Data :  ",               
                "sProcessing": "Loading data",
            },
            "ajax": {
                "url": "<?php echo site_url('surat/masuk/getdata'); ?>",
                "type": "post",
                "data": { 
                    [csrfName]: csrfHash,
                    'tanggal': bulan
                }
            },
            "columns": [
                {"mData": "no_agenda"},
                {"width":"10%","mData": "tgl_agenda"},
                {"mData": "asal_surat"},
                {"mData": "nomor_surat"},
                {"width":"10%","mData": "tgl_surat"},
                {"width":"20%","mData": "isi_surat"},
                {"mData": "sifat_surat"},
                {"width":"20%","mData": "disposisi_direktur"},
                {"mData": "disposisi_direktur_ke"},
                {"mData": "disposisi_wadir"},
                {"mData": "file_lampiran"},
                {"width":"15%","className": "text-center","mData": "aksi"},
            ]
        }); 
        myTable = $('#mytable').DataTable();  
        myTable.on('xhr.dt', function ( e, settings, json, xhr ) {
            var token = json.token;
            $('#txt_csrfname').val(token);
        });        
        $('#searchInput').keyup(function(){
            myTable.search($(this).val()).draw() ;
            $('.table').removeAttr('style');
        });       
    }  

    function getKodeUnit(kode)
    {
        $.ajax({
            url : "<?php echo site_url('surat/kodeunit'); ?>",
            type: "GET",
            dataType: "JSON",            
            success: function(data)
            {          
                var html = '';
                html +='<option value="">- Disposisi Kepada -</option>';
                for(var i=0; i<data.length; i++){                    
                    html += '<option value="'+data[i].kode_unit+','+data[i].nama_unit+'">'+data[i].nama_unit+'</option>';
                }  
                $('#disposisi_ke').html(html);
                if(kode){
                     $('#disposisi_ke option[value="'+kode+'"]').attr('selected','selected');
                }
                $(".select2").select2({
                    dropdownParent:  $('#modal-form'),
                    width: '100%'
                });
            },
            
        });      
    }

    $(document).on('click','#disDirektur',function(e){
        var kode = $(this).data('kode');
        $('#form-data')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url : "<?php echo site_url('surat/masuk/disdirektur'); ?>",
            type: "GET",
            dataType: "JSON",
            data : {                
                'kode' : kode
            },
            success: function(response)
            {          
                if(response.status==true){
                    var kode_unit=response.data.kode_unit;
                    var disposisi_unit = response.data.disposisi_unit;
                    var kode = kode_unit+','+disposisi_unit;
                    $('#modal-form').modal('show'); 
                    getKodeUnit(kode);
                    $('[name="kode_klasifikasi"]').val(response.data.kode_klasifikasi);
                    $('[name="no_agenda"]').val(response.data.no_agenda);
                    $('[name="tgl_agenda"]').val(response.data.tgl_agenda);                    
                    $('[name="tgl_disposisi"]').val(response.data.tgl_disposisi);
                    $('[name="isi_disposisi"]').val(response.data.isi_disposisi);                     
                    $('#kode_unit').val(response.data.kode_unit);
                    $('#jenis_diposisi').val('disposisi_direktur');
                    $('.modal-title').text('Disposisi Direktur');   
                }else{
                    alert('data tidak ditemukan');
                }            
            },
            error : function(xhr) {
                var errors = xhr.responseJSON; 
                $.each( errors.errors, function( key, value ) {
                    $("#" + key)
                        .parent().addClass('has-error')
                        .after().append('<span class="help-block"><strong>' +value[0]+ '</strong></span>');
                });
            }
        });      
    });

    $(document).on('click','#disWadir',function(e){
        var kode = $(this).data('kode');
        $('#form-data')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url : "<?php echo site_url('surat/masuk/diswadir'); ?>",
            type: "GET",
            dataType: "JSON",
            data : {                
                'kode' : kode
            },
            success: function(response)
            {          
                if(response.status==true){
                    var kode_unit=response.data.kode_unit;
                    var disposisi_unit = response.data.disposisi_unit;
                    var kode = kode_unit+','+disposisi_unit;
                    $('#modal-form').modal('show'); 
                    getKodeUnit(kode);
                    $('[name="kode_klasifikasi"]').val(response.data.kode_klasifikasi);
                    $('[name="no_agenda"]').val(response.data.no_agenda);
                    $('[name="tgl_agenda"]').val(response.data.tgl_agenda);                    
                    $('[name="tgl_disposisi"]').val(response.data.tgl_disposisi);
                    $('[name="isi_disposisi"]').val(response.data.isi_disposisi);                     
                    $('#kode_unit').val(response.data.kode_unit);
                    $('#jenis_diposisi').val('disposisi_wadir');
                    $('.modal-title').text('Disposisi Wakil Direktur');   
                }else{
                    alert('data tidak ditemukan');
                }            
            },
            error : function(xhr) {
                var errors = xhr.responseJSON; 
                $.each( errors.errors, function( key, value ) {
                    $("#" + key)
                        .parent().addClass('has-error')
                        .after().append('<span class="help-block"><strong>' +value[0]+ '</strong></span>');
                });
            }
        });      
    });

    $(document).on('click','#disUnit',function(e){
        var kode = $(this).data('kode');
        $('#form-data')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url : "<?php echo site_url('surat/masuk/disunit'); ?>",
            type: "GET",
            dataType: "JSON",
            data : {                
                'kode' : kode
            },
            success: function(response)
            {          
                if(response.status==true){
                    var kode_unit=response.data.kode_unit;
                    var disposisi_unit = response.data.disposisi_unit;
                    var kode = kode_unit+','+disposisi_unit;
                    var dropdown = document.getElementById("disposisi_kepada");
                    dropdown.style.display = 'none';
                    $('#modal-form').modal('show'); 
                    getKodeUnit(kode);                    
                    $('[name="kode_klasifikasi"]').val(response.data.kode_klasifikasi);
                    $('[name="no_agenda"]').val(response.data.no_agenda);
                    $('[name="tgl_agenda"]').val(response.data.tgl_agenda);                    
                    $('[name="tgl_disposisi"]').val(response.data.tgl_disposisi);
                    $('[name="isi_disposisi"]').val(response.data.isi_disposisi);                     
                    $('#kode_unit').val(response.data.kode_unit);
                    $('#jenis_diposisi').val('disposisi_unit');
                    $('.modal-title').text('Disposisi Unit');   
                }else{
                    alert('data tidak ditemukan');
                }            
            },
            error : function(xhr) {
                var errors = xhr.responseJSON; 
                $.each( errors.errors, function( key, value ) {
                    $("#" + key)
                        .parent().addClass('has-error')
                        .after().append('<span class="help-block"><strong>' +value[0]+ '</strong></span>');
                });
            }
        });      
    });


    $(document).on('click','#btn-save',function(e){
        var formdata = $('#form-data').serialize();
        var csrfName = $('#txt_csrfname').attr('name'); 
        var csrfHash = $('#txt_csrfname').val();
        var kode_unit = $('#kode_unit').val();
        var tgl_disposisi = $('#datepicker').val();
        var disposisi_ke = $('#disposisi_ke').val();
        var isi_disposisi = $('#isi_disposisi').val(); 
        var jenis_disposisi = $('#jenis_disposisi').val(); 
        if(kode_unit=='' && tgl_disposisi==''){
            alert('Tanggal Disposisi harus di isi');
        }else if(kode_unit=='' && disposisi_ke==''){
            alert('Tujuan Disposisi harus di isi');
        }else if(kode_unit=='' && isi_disposisi=='' && jenis_diposisi!='disposisi_unit'){
            alert('Keterangan Disposisi harus di isi');
        }else{
            $('#btn-save').prop('disabled', true);
            $('#btn-save').text('... Proses Simpan');
            $.ajax({
                url : "<?php echo site_url('surat/disposisi/simpan'); ?>",
                type:"POST",
                dataType: "json",
                data : formdata,
                success: function(response)
                {    
                    var token = response.token;
                    $('#txt_csrfname').val(token);      
                    $('#btn-save').prop('disabled', false);
                    $('#btn-save').text('Simpan');
                    $('#modal-form').modal('hide');
                    ajaxLoad();
                }
            });   
        }           
    });

</script>
<?= $this->endSection() ?>