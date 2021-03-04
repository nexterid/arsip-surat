<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="content">            
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-holder">
                    <h1 class="main-title float-left">Daftar Pengguna</h1>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">User</li>
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
                        <h3 class='box-title'><?php echo anchor('user/create', '<i class="fa fa-plus"> </i> Tambah Data', array('class' => 'btn btn-sm btn-primary')); ?>
                        </h3>
                    </div>                        
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mytable" class="table table-sm table-bordered table-hover display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Nama</th> 
                                        <th>Unit</th> 
                                        <th>Level</th>                                       
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
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script>
    $(document).ready(function () {
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
            "ajax": "<?php echo base_url('user/view_data'); ?>",
            "columns": [
                {"mData": "no"},                    
                {"mData": "username"},
                {"mData": "nama_pengguna"},
                {"mData": "kode_unit"},
                {"mData": "level"},
                {"mData": "aksi"},
            ]
        });
    });

</script>
<?= $this->endSection() ?>