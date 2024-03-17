<?php
include('../../config/config.php');

if (isset($_GET['memberId'])) {
    $memberId = $_GET['memberId'];
} else {
    $memberId = '';
}

if (isset($_POST['memberPayment'])) {
    $memberPayment = $_POST['memberPayment'];
} else {
    $memberPayment = '';
}

if (isset($_POST['member_payment'])) {
    $sql_get_member = "SELECT * FROM member WHERE memberId = '" . $memberPayment . "' LIMIT 1";
    $query_get_member = mysqli_query($mysqli, $sql_get_member);
    if ($query_get_member) {
        $member = mysqli_fetch_array($query_get_member);
        $memberName = $member['memberName'];

        // số dư của người sẽ được nhận thanh toán
        $memberSurplus = $member['totalExpend'] - $member['totalLoss'];
        
        // thực hiện nếu số dư lớn hơn 0
        if ($memberSurplus > 0) {

            // Thông tin của người sẽ thanh toán
            $sql_get_member_owner = "SELECT * FROM member WHERE memberId = '" . $memberId . "' LIMIT 1";
            $query_get_member_owner = mysqli_query($mysqli, $sql_get_member_owner);
            if ($query_get_member_owner) {
                $member_owner = mysqli_fetch_array($query_get_member_owner);

                $memberOwnerName = $member_owner['memberName']; // Tên người người sẽ thanh toán

                $ownerSurplus = $member_owner['totalExpend'] - $member_owner['totalLoss']; // Số dư của người sẽ thanh toán

                // 
                if(abs($memberSurplus) > abs($ownerSurplus)) {
                    $lastSurplusOwner = $member_owner['totalLoss'] - $ownerSurplus;
                    $lastSurplus = $memberSurplus - $ownerSurplus;
                } else {
                    $lastSurplusOwner = $ownerSurplus - $memberSurplus;
                    $lastSurplus = $ownerSurplus - $memberSurplus;
                }
                
                $sql_update_member_pay_owner = "UPDATE member SET totalLoss = '" . $lastSurplusOwner . "', memberNote = 'Vừa thanh toán cho $memberName' WHERE memberId = $memberId";
                mysqli_query($mysqli, $sql_update_member_pay_owner);
                
                $sql_update_member_pay_spend = "UPDATE member SET totalExpend = '" . $lastSurplus . "', memberNote = 'Vừa được thanh toán bởi $memberOwnerName'  WHERE memberId = $memberPayment";
                mysqli_query($mysqli, $sql_update_member_pay_spend);
                
                header("Location: ../../index.php?action=member&query=member_edit&memberId=$memberId&message=success");
                exit();
            } else {
                header("Location: ../../index.php?action=member&query=member_edit&memberId=$memberId&message=warning");
                exit();
            }
        } else {
            header("Location: ../../index.php?action=member&query=member_edit&memberId=$memberId&message=warning");
            exit();
        }
    } else {
        header("Location: ../../index.php?action=member&query=member_edit&memberId=$memberId&message=warning");
        exit();
    }
    header("Location: ../../index.php?action=member&query=member_edit&memberId=$memberId&message=warning");
}
