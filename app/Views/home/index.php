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
                    <a href="<?php echo base_url('surat/disposisi');?>">
                        <div class="card-box noradius noborder bg-danger">
                            <i class="fa fa-paper-plane float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">Surat</h6>
                            <h1 class="m-b-20 text-white counter">Disposisi</h1>
                        </div>
                    </a>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <a href="<?php echo base_url('unit');?>">
                        <div class="card-box noradius noborder bg-success">
                            <i class="fa fa-tags float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-120">Unit</h6>
                            <h1 class="m-b-20 text-white counter">Unit</h1>
                        </div>
                    </a>
                </div>
        </div>
        
    </div>
    <!-- END container-fluid -->
</div>
<?= $this->endSection() ?>