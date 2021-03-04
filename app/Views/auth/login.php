<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"> 
	<title>Login Arsip Surat Rsudkraton</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/my-login.css')?>">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="<?php echo base_url('assets/images/logo.png')?>">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login Arsip Surat</h4>
							<?php if(session()->getFlashdata('msg')):?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                            <?php endif;?>	
							<?= form_open('auth') ?>
								<div class="form-group">
									<label for="email">Username</label>
									<input id="username" type="text" class="form-control" name="username" value="<?= old('username') ?>" required autofocus oninvalid="setCustomValidity('Username tidak boleh kosong !')" oninput="setCustomValidity('')">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye oninvalid="setCustomValidity('Password tidak boleh kosong !')" oninput="setCustomValidity('')">
								</div>
								<div class="form-group">
									<label><input type="checkbox" name="remember"> Remember Me</label>
								</div>
								<div class="form-group no-margin">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
								</div>								
							</form>
						</div>
					</div>
					<div class="footer">
						DevelopBy &#64; IT RSUDKRATON 2021
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/my-login.js')?>"></script>
</body>
</html>