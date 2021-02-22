<div class="left main-sidebar">
    <div class="sidebar-inner leftscroll">
        <div id="sidebar-menu">    
        <ul>
        <?php 
        if($_SESSION['role']=='Admin'){            
            echo '
                <li class="submenu">
                    <a href="'.base_url('home').'"><i class="fa fa-fw fa-home"></i><span> HOME </span> </a>
                </li>
                <li class="submenu">
                    <a href="#" class="">
                        <i class="fa fa-fw fa-database"></i> <span> MASTER DATA</span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li class=""><a href="'.base_url('unit').'">Unit</a></li>
                        <li class=""><a href="'.base_url('klasifikasi').'">Klasifikasi</a></li>    
                        <li class=""><a href="'.base_url('user').'">User Akses</a></li>                      
                    </ul>
                </li>
                <li class="submenu">
                    <a href="'.base_url('surat/masuk').'"><i class="fa fa-envelope"></i><span> SURAT MASUK </span> </a>
                </li>
                <li class="submenu">
                    <a href="'.base_url('surat/keluar').'"><i class="fa fa-folder-open"></i><span> SURAT KELUAR </span> </a>
                </li>
            
            ';
        }
        else{
            echo '
                <li class="submenu">
                    <a href="'.base_url('home').'"><i class="fa fa-fw fa-home"></i><span> HOME </span> </a>
                </li>
                <li class="submenu">
                    <a href="'.base_url('home').'"><i class="fa fa-envelope"></i><span> SURAT MASUK </span> </a>
                </li>
                <li class="submenu">
                    <a href="'.base_url('home').'"><i class="fa fa-folder-open"></i><span> SURAT KELUAR </span> </a>
                </li>                                   
            ';
        }
        
        ?>           
        </ul>

        <!-- <div class="clearfix"></div> -->

        </div>
    
        <!-- <div class="clearfix"></div> -->

    </div>

</div>