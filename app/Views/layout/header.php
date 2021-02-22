<div class="headerbar">
    <!-- LOGO -->
    <div class="headerbar-left">
        <a href="<?php echo base_url();?>" class="logo"><img alt="logo" src="<?php echo base_url('assets/images/ic_home.png');?>" /> <span>ARSIP SURAT</span></a>
    </div>
    <nav class="navbar-custom">
        <ul class="list-inline float-right mb-0">  
            <li class="list-inline-item dropdown notif">
                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="<?php echo base_url('assets/images/avatars/admin.png');?>" alt="Profile image" class="avatar-rounded">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="text-overflow"><small>Login: <?php echo $_SESSION['nama'];?></small> </h5>
                    </div>

                    <!-- item
                    <a href="pro-profile.html" class="dropdown-item notify-item">
                        <i class="fa fa-user"></i> <span>Profile</span>
                    </a> -->

                    <!-- item-->
                    <a href="<?php echo base_url('logout'); ?>" class="dropdown-item notify-item">
                        <i class="fa fa-power-off"></i> <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </li>                        
        </ul>
    </nav>
</div>