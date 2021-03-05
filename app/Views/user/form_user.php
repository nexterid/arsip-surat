<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="content">            
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-holder">
                    <h1 class="main-title float-left">Form Master User</h1>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active">Form</li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
		<div class="row">
			<div class="col-xl-12">						
                <div class="card mb-3">  
                    <div class="col-xl-6">
                        <div class="card-body">	
                            <form action="<?php echo $action; ?>" method="post">                               
                                <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                <input type="hidden" name="id" id="id" value="<?= $id; ?>" data-parsley-trigger="change" class="form-control" >
                                <div class="form-group">
                                    <label for="username">Username<span class="text-danger">*</span></label> 
                                    <input type="text" name="username" id="username" value="<?= $username; ?>" data-parsley-trigger="change" required="" placeholder="username" class="form-control <?=($validation->hasError('username'))?'is-invalid':'' ?>" >
                                    <div class="invalid-feedback">
                                        <?=$validation->getError('username');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pengguna">Nama Pengguna<span class="text-danger">*</label>
                                    <input type="text" name="nama" id="nama" value="<?= $nama; ?>" data-parsley-trigger="change"  placeholder="Nama Pengguna" class="form-control <?=($validation->hasError('nama'))?'is-invalid':'' ?>" >
                                    <div class="invalid-feedback">
                                        <?=$validation->getError('nama');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" value="<?= $password; ?>" data-parsley-trigger="change" placeholder="Password" class="form-control <?=($validation->hasError('password'))?'is-invalid':'' ?>" >
                                    <div class="invalid-feedback">
                                        <?=$validation->getError('password');?>
                                    </div>
                                </div>                                                                   
                                <div class="form-group">
                                    <label for="gld">Unit<span class="text-danger">*</span></label>
                                    <?= form_dropdown('kode_unit', $unit,$kode_unit, 'class="form-control select2" id="unit"'); ?>
                                    <div class="invalid-feedback">
                                        <?=$validation->getError('kode_unit');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status">Hak Akses<span class="text-danger">*</span> <?='<span class="text-danger">'.$validation->getError('role').'</span>' ?></label>
                                    <?= form_dropdown('role', ['Admin' => 'Admin', 'Direktur' => 'Direktur','Wadir'=>'Wadir','Unit'=>'Unit'],$role, 'class="form-control" id="role"'); ?>	
                                </div>
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary" type="submit"><?= $button;?></button>
                                    <a href="javascript:history.back()" class="btn btn-secondary m-l-5">Cancel</a>
                                    
                                </div>
                            </form>                            
                        </div>
                    </div>
                </div>                        
            </div>														
        </div>	
    </div>			
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js');?>"></script>
<script>								
	$(document).ready(function() {
		$('.select2').select2();
	});
</script>
<?= $this->endSection() ?>