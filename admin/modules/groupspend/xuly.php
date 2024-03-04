<?php
    include('../../config/config.php');
    $data = $_GET['data'];
    $groupspendIds = json_decode($data);
    $groupspendId = $_GET['groupspend_id'];
    $groupspendName = $_POST['groupspendName'];

    if (isset($_POST['groupspend_add'])) {
        $sql_add = "INSERT INTO groupspend(groupName) VALUE('".$groupspendName."')";
        mysqli_query($mysqli, $sql_add);
        header('Location: ../../index.php?action=groupspend&query=groupspend_list&message=success');
    }
    elseif (isset($_POST['groupspend_edit'])) {
        $sql_update = "UPDATE groupspend SET groupName='".$groupspendName."' WHERE groupId = '$_GET[groupspend_id]'";
        mysqli_query($mysqli, $sql_update);
        header('Location: ../../index.php?action=groupspend&query=groupspend_list&message=success');
    }
    else {
        foreach ($groupspendIds as $id) {
        $sql_delete = "DELETE FROM groupspend WHERE groupId = '".$id."'";
        mysqli_query($mysqli, $sql_delete);
        header('Location: ../../index.php?action=groupspend&query=groupspend_list&message=success');
        }
    }
?>

