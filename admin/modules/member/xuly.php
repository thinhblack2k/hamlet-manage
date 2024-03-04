<?php
    include('../../config/config.php');
    if (isset($_GET['data'])) {
        $data = $_GET['data'];
        $memberIds = json_decode($data);
    } else {
        $data = [];
        $memberIds = '';
    }
    
    if (isset($_GET['memberId'])) {
        $memberId = $_GET['memberId'];
    }
    else {
        $memberId = '';
    }
    
    $memberName = $_POST['memberName'];
    $totalExpend = $_POST['totalExpend'];
    $totalLoss = $_POST['totalLoss'];
    $memberNote = $_POST['memberNote'];
    $memberImage = $_FILES['memberImage']['name'];
    $memberImage_tmp = $_FILES['memberImage']['tmp_name'];
    $memberImage = time() . '_' . $memberImage;

    if (isset($_POST['member_add'])) {
        $sql_add = "INSERT INTO member(memberName, totalExpend, totalLoss, memberNote, memberImage) VALUE('".$memberName."', '".$totalExpend."', '".$totalLoss."', '".$memberNote."', '".$memberImage."')";
        mysqli_query($mysqli, $sql_add);
        move_uploaded_file($memberImage_tmp, 'uploads/'.$memberImage);
        header('Location: ../../index.php?action=member&query=member_list');
    }
    elseif (isset($_POST['member_edit'])) {
        if ($_FILES['memberImage']['name'] != '') {
            move_uploaded_file($memberImage_tmp, 'uploads/' . $memberImage);
            $sql = "SELECT * FROM member WHERE memberId = '$memberId' LIMIT 1";
            $query = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_array($query)) {
                unlink('uploads/' . $row['memberImage']);
            }
            $sql_update = "UPDATE member SET memberName='".$memberName."', totalExpend = '".$totalExpend."', totalLoss = '".$totalLoss."', memberNote = '".$memberNote."', memberImage = '".$memberImage."'  WHERE memberId = '$_GET[memberId]'";
        }
        else {
            $sql_update = "UPDATE member SET memberName='".$memberName."', totalExpend = '".$totalExpend."', totalLoss = '".$totalLoss."', memberNote = '".$memberNote."'  WHERE memberId = '$_GET[memberId]'";
        }
        
        mysqli_query($mysqli, $sql_update);
        header('Location: ../../index.php?action=member&query=member_list');
    }
    else {
        foreach ($memberIds as $id) {
        $sql = "SELECT * FROM member WHERE memberId = '$id' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($query)) {
            unlink('uploads/' . $row['memberImage']);
        }
        $sql_delete = "DELETE FROM member WHERE memberId = '".$id."'";
        mysqli_query($mysqli, $sql_delete);
        header('Location: ../../index.php?action=member&query=member_list');
        }
    }
