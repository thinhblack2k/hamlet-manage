<?php
include('../../config/config.php');

if (isset($_POST['codebaomat'])) {
    $code = $_POST['codebaomat'];
} else {
    $code = '';
}
if (isset($_POST['thanhkhoan'])) {
    if ($code == 'xom225manage') {
        $sql_update = "Update member SET totalExpend = 0, totalLoss = 0, memberNote = 'Vừa được thanh khoản'";
        $query_update = mysqli_query($mysqli, $sql_update);
        header('Location: ../../index.php?action=settings&query=settings&message=success');
    } else {
        header('Location: ../../index.php?action=settings&query=settings&message=error');
    }
} else if (isset($_POST['chotchitieu'])) {
    if ($code == 'xom225manage') {
        $sql_update = "Update spending SET spendingStatus = -1";
        $query_update = mysqli_query($mysqli, $sql_update);
        $sql_update_paymentgroup = "Update paymentgroup SET paymentStatus = -1";
        $query_update_paymentgroup = mysqli_query($mysqli, $sql_update_paymentgroup);
        header('Location: ../../index.php?action=settings&query=settings&message=success');
    } else {
        header('Location: ../../index.php?action=settings&query=settings&message=error');
    }
} else if (isset($_POST['lammoichitieu'])) {
    if ($code == 'xom225manage') {
        $sql_delete = "DELETE FROM spending";
        $query_delete = mysqli_query($mysqli, $sql_delete);
        $sql_delete_paymentgroup= "DELETE FROM paymentgroup";
        $query_delete_payment_group = mysqli_query($mysqli, $sql_delete_paymentgroup);
        $sql_update = "Update member SET totalExpend = 0, totalLoss = 0, memberNote = 'Vừa được thanh khoản'";
        $query_update = mysqli_query($mysqli, $sql_update);
        header('Location: ../../index.php?action=settings&query=settings&message=success');
    } else {
        header('Location: ../../index.php?action=settings&query=settings&message=error');
    }
} else if (isset($_POST['resettoanbohethong'])) {
    if ($code == 'xom225manage') {
        $sql_delete_group = "DELETE FROM groupspend";
        $sql_delete_member = "DELETE FROM member";
        $sql_delete_paymentgroup = "DELETE FROM paymentgroup";
        $sql_delete_spending = "DELETE FROM spending";

        //$query_delete_group = mysqli_query($mysqli, $sql_delete_group);
        //$query_delete_member = mysqli_query($mysqli, $sql_delete_member);
        $query_delete_paymentgroup = mysqli_query($mysqli, $sql_delete_paymentgroup);
        $query_delete_spending = mysqli_query($mysqli, $sql_delete_spending);
        header('Location: ../../index.php?action=settings&query=settings&message=success');
    } else {
        header('Location: ../../index.php?action=settings&query=settings&message=error');
    }
} else {
    header('Location: ../../index.php?action=settings&query=settings&message=error');
}
