<?php
session_start();
?>
<style>
    .main-sidebar {
        pointer-events: none;
    }

    .nav-item {
        pointer-events: auto;
    }

    .nav-link.active{
        background-color: #9B111E;
    }

</style>
<aside class="main-sidebar sidebar-light-navy elevation-4" style="background-color: #222D32;box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.25), 0px 0px 0px rgba(0, 0, 0, 0.22) !important;">
    <a href="" class="brand-link" style="background-color: #801818">
        <img src="images/logo.png"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="background-color: transparent">
        <span class="brand-text font-weight-light text-white">ระบบจัดการแพ็คสินค้า</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 d-flex">
            <div class="image">
                <img src="assets/uploads/member_pic/<?php if($_SESSION['Member_pic'] == '' ){ echo 'Default_Pic_Profile.png' ;  }else{ echo $_SESSION['Member_pic'] ;} ?>"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <span class="d-block text-white"><?php echo $_SESSION['Member_name'] . '&nbsp;' . $_SESSION['Member_last_name']; ?></span>
            </div>
        </div>

        <nav class="mt-1">
            <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
<!--                <li class="nav-header text-white">MAIN NAVIGATION</li>-->
                <li class="nav-item select-menu" data-id="dashboard" style="cursor: pointer; background-color: transparent;">
                    <a class="nav-link text-white active" style="background-color: #9B111E; color: white !important;">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <?php
                if($_SESSION['member_type'] == 2 || $_SESSION['member_type'] == 1){
                ?>
                <li class="nav-item select-menu" data-id="manage_emp" style="cursor: pointer; background-color: transparent;">
                    <a class="nav-link text-white" style="color: white !important;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="6" r="4" fill="white"/><path fill="white" d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5"/></svg>
                        <p>จัดการพนักงาน </p>
                    </a>
                </li>
                <?php }else{ ?>
                <?php } ?>
                <li class="nav-item" style="background-color: transparent;">
                    <a href="controller/authen/logout.php" class="nav-link text-white" style="color: white !important;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path fill="white" fill-rule="evenodd" d="M10.138 1.815A3 3 0 0 1 14 4.688v14.624a3 3 0 0 1-3.862 2.873l-6-1.8A3 3 0 0 1 2 17.512V6.488a3 3 0 0 1 2.138-2.873zM15 4a1 1 0 0 1 1-1h3a3 3 0 0 1 3 3v1a1 1 0 1 1-2 0V6a1 1 0 0 0-1-1h-3a1 1 0 0 1-1-1m6 12a1 1 0 0 1 1 1v1a3 3 0 0 1-3 3h-3a1 1 0 1 1 0-2h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1M9 11a1 1 0 1 0 0 2h.001a1 1 0 1 0 0-2z" clip-rule="evenodd"/><path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h5m0 0l-2-2m2 2l-2 2"/></g></svg>
                        <p>ออกจากระบบ </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<script>
    document.querySelectorAll('.nav-link').forEach(function(link) {
        link.addEventListener('mouseover', function() {
            this.style.backgroundColor = '#9B111E';
            this.style.color = 'white';
        });
        link.addEventListener('mouseout', function() {
            if (!this.classList.contains('active')) {
                this.style.backgroundColor = 'transparent';
                this.style.color = 'white';
            }
        });
    });
</script>