<div class="main-panel">
    <div class="content-wrapper">
        <?php
        if (isset($_GET['action']) && $_GET['query']) {
            $action = $_GET['action'];
            $query = $_GET['query'];

        } else {
            $action = '';
            $query = '';
        }
        if ($action == 'dashboard' && $query == 'dashboard') {
            include("./modules/dashboard.php");
        }
        elseif ($action == 'spending' && $query == 'spending_list') {
            include("./modules/spending/lietke.php");
        }
        elseif ($action == 'spending' && $query == 'spending_add') {
            include("./modules/spending/them.php");
        }
        elseif ($action == 'spending' && $query == 'spending_edit') {
            include("./modules/spending/sua.php");
        }
        elseif ($action == 'spending' && $query == 'spending_search') {
            include("./modules/spending/timkiem.php");
        }
        elseif($action =='spending' && $query == 'spending_detail') {
            include("./modules/spending/chitiet.php");
        }
        elseif ($action == 'payment' && $query == 'payment_list') {
            include("./modules/payment/lietke.php");
        }
        elseif ($action == 'payment' && $query == 'payment_add') {
            include("./modules/payment/them.php");
        }
        elseif ($action == 'payment' && $query == 'payment_edit') {
            include("./modules/payment/sua.php");
        }
        elseif($action =='groupspend' && $query == 'groupspend_add') {
            include("./modules/groupspend/them.php");
        }
        elseif($action =='groupspend' && $query == 'groupspend_list') {
            include("./modules/groupspend/lietke.php");
        }
        elseif($action =='groupspend' && $query == 'groupspend_edit') {
            include("./modules/groupspend/sua.php");
        }
        elseif($action =='groupspend' && $query == 'groupspend_search') {
            include("./modules/groupspend/timkiem.php");
        }
        elseif($action =='account' && $query == 'my_account') {
            include("./modules/account/my_account.php");
        }
        elseif($action =='account' && $query == 'password_change') {
            include("./modules/account/password_change.php");
        }
        elseif($action =='account' && $query == 'account_list') {
            include("./modules/account/lietke.php");
        }
        elseif($action =='account' && $query == 'account_edit') {
            include("./modules/account/sua.php");
        }
        elseif($action =='account' && $query == 'account_add') {
            include("./modules/account/them.php");
        }
        elseif($action =='member' && $query == 'member_add') {
            include("./modules/member/them.php");
        }
        elseif($action =='member' && $query == 'member_list') {
            include("./modules/member/lietke.php");
        }
        elseif($action =='member' && $query == 'member_edit') {
            include("./modules/member/sua.php");
        }
        elseif($action =='settings' && $query == 'settings') {
            include("./modules/settings/main.php");
        }
        else {
            include("./modules/home.php");
        }
        ?>
    </div>
</div>