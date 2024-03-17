<?php 
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }
    else {
        $action = "-1";
    }

    if (isset($_GET['query'])) {
        $query = $_GET['query'];
    }
    else {
        $query = "-1";
    }
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item <?php if ($action === 'home') { echo "active"; } ?>">
            <a class="nav-link" href="index.php?action=home&query">
                <i class="menu-icon mdi mdi-home"></i>
                <span class="menu-title">Trang chủ</span>
            </a>
        </li>
        <li class="nav-item <?php if ($action === 'spending') { echo "active"; } ?>">
            <a class="nav-link" href="index.php?action=spending&query=spending_list">
                <i class="menu-icon mdi mdi-calendar-multiple-check"></i>
                <span class="menu-title">Chi tiêu</span>
            </a>
        </li>
        <li class="nav-item <?php if ($action === 'payment') { echo "active"; } ?>">
            <a class="nav-link" href="index.php?action=payment&query=payment_list">
                <i class="mdi mdi-barcode-scan menu-icon"></i>
                <span class="menu-title">Thanh toán</span>
            </a>
        </li>
        <li class="nav-item <?php if ($action === 'groupspend') { echo "active"; } ?>">
            <a class="nav-link" href="index.php?action=groupspend&query=groupspend_list">
                <i class="menu-icon mdi mdi-folder-multiple-outline"></i>
                <span class="menu-title">Loại chi tiêu</span>
            </a>
        </li>
        <li class="nav-item <?php if ($action === 'member') { echo "active"; } ?>">
            <a class="nav-link" href="index.php?action=member&query=member_list">
                <i class="mdi mdi-account-box-outline menu-icon"></i>
                <span class="menu-title">Thành viên</span>
            </a>
        </li>
        <li class="nav-item <?php if ($action === 'account') { echo "active"; } ?>">
            <a class="nav-link" href="index.php?action=account&query=account_list">
                <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                <span class="menu-title">Tài khoản</span>
            </a>
        </li>
        <li class="nav-item <?php if ($action === 'settings') { echo "active"; } ?>">
            <a class="nav-link" href="index.php?action=settings&query=settings">
                <i class="menu-icon mdi mdi-settings-box"></i>
                <span class="menu-title">Cài đặt</span>
            </a>
        </li>
    </ul>
</nav>