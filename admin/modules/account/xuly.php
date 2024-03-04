<?php
include('../../config/config.php');
if (isset($_GET['data'])) {
    $data = $_GET['data'];
} else {
    $data = '';
}

if (isset($_GET['accountId'])) {
    $accountId = $_GET['accountId'];
} else {
    $accountId = "";
}
$accountIds = json_decode($data);
$userName = $_POST['userName'];
$password = md5($_POST['password']);
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$role = $_POST['role'];
$status = $_POST['status'];
$accountImage = $_FILES['accountImage']['name'];
$accountImage_tmp = $_FILES['accountImage']['tmp_name'];
$accountImage = time() . '_' . $accountImage;

print_r($role);

if (isset($_POST['account_add'])) {
    $sql_add = "INSERT INTO account(userName, accountPassword, lastName, firstName, accountImage, accountRole , accountStatus) VALUE('" . $userName . "', '" . $password . "', '" . $lastName . "',  '" . $firstName . "', '" . $accountImage . "', '" . $role . "','" . $status . "')";
    echo $sql_add;
    mysqli_query($mysqli, $sql_add);
    move_uploaded_file($accountImage_tmp, 'uploads/' . $accountImage);
    header('Location: ../../index.php?action=account&query=account_list&message=success');
}

if (isset($_POST['account_edit'])) {
    if ($_FILES['accountImage']['name'] != '') {
        move_uploaded_file($accountImage_tmp, 'uploads/' . $accountImage);
        $sql = "SELECT * FROM account WHERE accountId = '$accountId' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($query)) {
            unlink('uploads/' . $row['accountImage']);
        }
        $sql_update = "UPDATE account SET userName='".$userName."', lastName = '".$lastName."', firstName = '".$firstName."', accountImage = '".$accountImage."', accountRole = '".$role."', accountStatus = '".$status."'  WHERE accountId = '$_GET[accountId]'";
    }
    else {
        $sql_update = "UPDATE account SET userName='".$userName."', lastName = '".$lastName."', firstName = '".$firstName."', accountRole = '".$role."', accountStatus = '".$status."'  WHERE accountId = '$_GET[accountId]'";
    }
    mysqli_query($mysqli, $sql_update);
    header('Location: ../../index.php?action=account&query=account_list&message=success');
}

if (isset($_POST['account_change'])) {
    if ($_SESSION['account_type'] == 2 && $_SESSION['account_id_admin'] != $account_id) {
        $account_type = $_POST['account_type'];
        $account_status = $_POST['account_status'];
        $sql_update_account = "UPDATE account SET account_type = $account_type, account_status = $account_status WHERE account_id = $account_id";
        $query_update_account = mysqli_query($mysqli, $sql_update_account);

        header('Location:../../index.php?action=account&query=account_list&message=success');
    } else {
        header('Location:../../index.php?action=account&query=account_list&message=error');
    }
}
