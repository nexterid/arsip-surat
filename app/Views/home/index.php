<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="content">            
    <div class="container-fluid">					
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-holder">
                    <h1 class="main-title float-left">Quick Menu</h1>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->        
        <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <a href="<?php echo base_url('surat/masuk');?>">
                        <div class="card-box noradius noborder bg-default">
                            <i class="fa fa-envelope float-right text-white"></i> 
                            <h6 class="text-white text-uppercase m-b-20">Surat</h6>
                            <h1 class="m-b-20 text-white ">Masuk
                            </h1>
                        </div>
                    </a>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <a href="<?php echo base_url('surat/keluar');?>">
                        <div class="card-box noradius noborder bg-warning">
                            <i class="fa fa-folder-open float-right text-white"></i> 
                            <h6 class="text-white text-uppercase m-b-20">Surat</h6>
                            <h1 class="m-b-20 text-white ">Keluar
                            </h1>
                        </div>
                    </a>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <a href="<?php echo base_url('klasifikasi');?>">
                        <div class="card-box noradius noborder bg-danger">
                            <i class="fa fa-paper-plane float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">Master</h6>
                            <h1 class="m-b-20 text-white counter">Klasifikasi</h1>
                        </div>
                    </a>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <a href="<?php echo base_url('unit');?>">
                        <div class="card-box noradius noborder bg-success">
                            <i class="fa fa-tags float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-120">Master</h6>
                            <h1 class="m-b-20 text-white counter">Unit</h1>
                        </div>
                    </a>
                </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h3>
                            <i class="fa fa-paper-plane"></i> Surat Masuk
                            <span class="pull-right">
                                <select name="bulan" id="bulan" class="form-control form-control-sm" onchange="ajaxLoad()">
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
                            </span>    
                        </h3>             
                    </div>                        
                    <div class="card-body">
                        <table width="100%" id="mytable" class="table table-sm table-responsive-xl">
                            <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <thead>
                                <tr bgcolor="#E5E5E5" style="height:45px;">
                                    <th>Tgl Agenda</th>
                                    <th>Asal Surat</th>                                   
                                    <th>Tgl Surat</th>
                                    <th width="35%">Isi Surat</th>
                                    <th>Lampiran</th>
                                </tr>
                            </thead>										
                            <tbody></tbody>
                        </table>
                    </div>
                </div>                	
            </div>
        </div>
        
    </div>
    <!-- END container-fluid -->
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script>
     $(document).ready(function () {               
        ajaxLoad();
    });

    function ajaxLoad(){          
        var csrfName = $('#txt_csrfname').attr('name'); 
        var csrfHash = $('#txt_csrfname').val();   
        var bulan =$('#bulan').val();
        console.log(bulan);
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
                {"width":"12%","mData": "tgl_agenda"},
                {"width":"10%","mData": "asal_surat"},
                {"width":"12%","mData": "tgl_surat"},
                {"mData": "isi_surat"},
                {"width":"10%","mData": "file_lampiran"},
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