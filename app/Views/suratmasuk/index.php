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
                                        <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
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
    <!-- END container-fluid -->
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js'); ?>"></script>

<script>
    $(document).ready(function () {
        $('.table').removeAttr('style');
        ajaxLoad();
    });

    function ajaxLoad(){          
        var csrfName = $('#txt_csrfname').attr('name'); 
        var csrfHash = $('#txt_csrfname').val();   
        var bulan =$('#bulan').val();
        console.log(csrfHash);
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
                "url": "<?php echo base_url('surat/masuk/getdata'); ?>",
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
                {"width":"30%","mData": "isi_surat"},
                {"mData": "sifat_surat"},
                {"mData": "disposisi_direktur"},
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
</script>
<?= $this->endSection() ?>