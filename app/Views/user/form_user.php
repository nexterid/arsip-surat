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
                            <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                                <input type="hidden" name="id_user" id="id_user" value="<?= $id_user; ?>"<?= !empty($id_user) ? "readonly" : ""?> data-parsley-trigger="change" class="form-control" >
                            <div class="form-group">
                                <label for="username">Username<span class="text-danger">*</span> <?php echo form_error('username') ?></label> 
                                <input type="email" name="username" id="username" value="<?= $username; ?>" data-parsley-trigger="change" required="" placeholder="username" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="nama_pengguna">Nama Pengguna<span class="text-danger">*</span> <?php echo form_error('nama_pengguna') ?></label>
                                <input type="text" name="nama_pengguna" id="nama_pengguna" value="<?= $nama_pengguna; ?>" data-parsley-trigger="change" required="" placeholder="Nama Pengguna" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="password">Password<span class="text-danger">*</span> <?php echo form_error('password') ?></label>
                                <input type="password" name="password" id="password" value="<?= $password; ?>" data-parsley-trigger="change" placeholder="Password" class="form-control" >
                            </div>   
                            <div class="form-group">
                                <label for="status">Status<span class="text-danger">*</span> <?php echo form_error('status') ?></label>
                                <?= form_dropdown('status', ['Aktif' => 'Aktif', 'Non Aktif' => 'Non AKtif'],$status, 'class="form-control" id="status"'); ?>	
                            </div>                                                                          
                            <div class="form-group">
                                <label for="gld">Group<span class="text-danger">*</span> <?php echo form_error('gid') ?></label>
                                <?= form_dropdown('gid', $groups,$groups_selected, 'class="form-control select" id="gid"'); ?>	
                            </div>
                            <div class="form-group">
                                <label for="gld">Bagian <span class="text-danger">*</span> <?php echo form_error('bagian') ?></label>
                                <?= form_dropdown('bagian', $unitkerja,$bagian_selected, 'class="form-control select2" id="bagian"'); ?>	
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