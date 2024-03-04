<?php
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    unset($_GET['account_id_admin']);
    unset($_SESSION['login']);
    unset($_SESSION['account_name']);
    unset($_SESSION['account_type']);
    header('Location:../admin/login');
}
$sql_member_list = "SELECT * FROM member ORDER BY memberId ASC";
$query_member_list = mysqli_query($mysqli, $sql_member_list);
?>
<nav class="navbar none-wrap default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="index.php?action=home&query">
                <img src="images/logo225.png" alt="Xóm225" style="width: 120px; height: 55px;" />
            </a>
        </div>
    </div>
    <div>
        <a class="logo-mobile" href="index.php?action=home&query">
            <img src="images/logo225.png" alt="Xóm225" style="width: 120px; height: 55px;" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text" style="margin: 0px;">Xin chào, <span class="text-black fw-bold"><?php if (isset($_SESSION['account_name'])) {
                                                                                                                echo $_SESSION['account_name'];
                                                                                                            } ?></span></h1>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="icon-bell"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
                    <a class="dropdown-item py-3">
                        <p class="mb-0 font-weight-medium float-left">Bạn có thông báo mới </p>
                        <span class="badge badge-pill badge-primary float-right">View all</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_array($query_member_list)) {
                        $i++;
                    ?>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img class="image-cover" src="modules/member/uploads/<?php echo $row['memberImage'] ?>" alt="<?php echo $row['memberName'] ?>">
                            </div>
                            <div class="preview-item-content flex-grow py-2">
                                <p class="preview-subject ellipsis font-weight-medium text-dark"><?php echo $row['memberName'] ?></p>
                                <p class="fw-light small-text mb-0"><td><?php echo $row['memberNote'] ?></td></p>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </li>
            <li class="nav-item dropdown user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="images/user.png" alt="Profile image"> </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="images/user.png" alt="Profile image">
                        <p class="mb-1 mt-3 font-weight-semibold"><?php if (isset($_SESSION['account_name'])) {
                                                                        echo $_SESSION['account_name'];
                                                                    } ?></p>
                        <p class="fw-light text-muted mb-0"><?php echo $_SESSION['login'] ?></p>
                    </div>
                    <a href="index.php?action=account&query=my_account" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger"></span></a>
                    <a href="https://www.facebook.com/edricdang310" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a>
                    <a href="index.php?logout=1" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Đăng xuất</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>