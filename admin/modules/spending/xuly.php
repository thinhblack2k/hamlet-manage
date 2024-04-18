<?php
include('../../config/config.php');
require_once '../../mail/index.php';
if (isset($_GET['data'])) {
    $data = $_GET['data'];
} else {
    $data = '';
}

if (isset($_GET['spendId'])) {
    $spendId = $_GET['spendId'];
} else {
    $spendId = "";
}

function generateUniqueRandomString($length = 10)
{
    // Tạo chuỗi ngẫu nhiên không trùng lặp bằng cách kết hợp uniqid() và mã hóa SHA1
    $uniqueString = sha1(uniqid(mt_rand(), true));

    // Trả về một phần của chuỗi để đảm bảo độ dài mong muốn
    return substr($uniqueString, 0, $length);
}

$spend_ids = json_decode($data);
$spendName = $_POST['spendName'];
$spendTotal = $_POST['spendTotal'];
$spendMember = $_POST['spendMember']; // người tạm thanh toán
$spendGroup = generateUniqueRandomString(10);
if (isset($_POST['paymentGroup'])) {
    $memberCount = count($_POST['paymentGroup']); // số người tham gia
} else {
    $memberCount = 0; // số người tham gia
}
$groupId = $_POST['groupId'];
$spendDate = $_POST['spendDate'];
if (isset($_POST['spendStatus'])) {
    $spendStatus = $_POST['spendStatus'];
} else {
    $spendStatus = "";
}
$paymentGroup = $_POST['paymentGroup']; //nhóm những người chia tiền 

if (isset($_POST['spend_add'])) {
    $sql_add = "INSERT INTO spending(spendName, spendTotal, spendMember, spendGroup, memberCount, groupId, spendDate) VALUE('" . $spendName . "', '" . $spendTotal . "', '" . $spendMember . "',  '" . $spendGroup . "', '" . $memberCount . "', '" . $groupId . "', '" . $spendDate . "')";
    mysqli_query($mysqli, $sql_add);
    foreach ($paymentGroup as $memberId) {
        $sql_insert_paymentgroup = "INSERT INTO paymentgroup(spendGroup, memberId, groupId) VALUE('" . $spendGroup . "', '" . $memberId . "', '" . $groupId . "');";
        mysqli_query($mysqli, $sql_insert_paymentgroup);

        // Lấy ra thông tin hiện tại của thành viên
        $sql_get_member = "SELECT * FROM member WHERE memberId = '" . $memberId . "' LIMIT 1";
        $query_get_member = mysqli_query($mysqli, $sql_get_member);
        $member = mysqli_fetch_array($query_get_member);
        $totalLossNew = $member['totalLoss'] + ($spendTotal / $memberCount);

        $sql_update_member = "UPDATE member SET totalLoss = '" . $totalLossNew . "', memberNote = 'Tham gia khoản chi' WHERE memberId = $memberId";
        mysqli_query($mysqli, $sql_update_member);
    }
    // Lấy ra thông tin cũ của thành viên đã chi
    $sql_get_member_spending = "SELECT * FROM member WHERE memberId = '" . $spendMember . "' LIMIT 1";
    $query_get_member_spending = mysqli_query($mysqli, $sql_get_member_spending);
    $member = mysqli_fetch_array($query_get_member_spending);
    $totalExpendNew = $member['totalExpend'] + $spendTotal;

    // gửi mail
    $email_content = '<h4>' . $member['memberName'] . ' vừa thêm 1 khoản chi mới</h4>
        <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <th style="padding: 8px; border: 1px solid #dddddd;">Nội dung</th>
            <th style="padding: 8px; border: 1px solid #dddddd;">Người chi</th>
            <th style="padding: 8px; border: 1px solid #dddddd;">Số tiền</th>
            <th style="padding: 8px; border: 1px solid #dddddd;">Tham gia</th>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . $spendName . '</td>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . $member['memberName'] . '</td>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . number_format($spendTotal) . 'đ</td>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . $memberCount . '</td>
        </tr>
        </table>
        </br>
        </br>
        <h4>Thống kê số dư</h4>
        <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <th style="padding: 8px; border: 1px solid #dddddd;">Tên thành viên</th>
            <th style="padding: 8px; border: 1px solid #dddddd;">Số dư</th>
        </tr>';

    $sql_get_member_info = "SELECT * FROM member";
    $query_get_member_info = mysqli_query($mysqli, $sql_get_member_info);

    while ($member = mysqli_fetch_array($query_get_member_info)) {
        $email_content .= '<tr>
            <td style="padding: 8px; border: 1px solid #dddddd; width: 120px;">' . $member['memberName'] . '</td>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . number_format($member['totalExpend'] - $member['totalLoss']) . '</td>
        </tr>';
    }

    $email_content .= '</table>';

    foreach ($paymentGroup as $memberId) {
        // Lấy ra thông tin hiện tại của thành viên
        $sql_get_member = "SELECT * FROM member WHERE memberId = '" . $memberId . "' LIMIT 1";
        $query_get_member = mysqli_query($mysqli, $sql_get_member);
        $member = mysqli_fetch_array($query_get_member);
        if ($member['memberEmail'] != null && $member['memberEmail'] != "") {
            sendEmail($member['memberEmail'], $email_content);
        }
    }
    $sql_update_member_spending = "UPDATE member SET totalExpend = '" . $totalExpendNew . "', memberNote = 'Vừa thêm 1 khoản chi mới'  WHERE memberId = $spendMember";
    mysqli_query($mysqli, $sql_update_member_spending);



    header('Location: ../../index.php?action=spending&query=spending_list&message=success');
} elseif (isset($_POST['spend_edit'])) {
    $spendId = $_GET['spendId']; // Lấy spendId từ query string

    // Lấy thông tin của spending cần chỉnh sửa
    $sql_get_spending = "SELECT * FROM spending WHERE spendId = $spendId";
    $query_get_spending = mysqli_query($mysqli, $sql_get_spending);
    $spending = mysqli_fetch_array($query_get_spending);

    // Cập nhật dữ liệu của spending trong cơ sở dữ liệu
    $sql_update = "UPDATE spending SET spendName = '$spendName', spendTotal = '$spendTotal', spendMember = '$spendMember', memberCount = '$memberCount', groupId = '$groupId', spendDate = '$spendDate' WHERE spendId = $spendId";
    mysqli_query($mysqli, $sql_update);

    // Lấy ra thông tin người đã chi trả
    $sql_get_member = "SELECT * FROM member WHERE memberId = '$spendMember' LIMIT 1";
    $query_get_member = mysqli_query($mysqli, $sql_get_member);
    $member_spend = mysqli_fetch_array($query_get_member);

    $totalAmount = $member_spend['totalExpend'] - $spending['spendTotal'];

    // Cập nhật lại số tiền đã chi trả
    $sql_update_spend_member = "UPDATE member SET totalExpend = $totalAmount WHERE memberId = '$spendMember'";
    mysqli_query($mysqli, $sql_update_spend_member);

    // Lấy ra memberId từ trong paymentGroup lưu vào 1 mảng
    $sql_get_paymentgroup_old = "SELECT memberId FROM paymentgroup WHERE spendGroup = '" . $spending['spendGroup'] . "'";
    $query_get_paymentgroup_old = mysqli_query($mysqli, $sql_get_paymentgroup_old);

    $memberIds = array(); // Khởi tạo mảng để lưu memberId

    // Lặp qua từng dòng dữ liệu và lưu memberId vào mảng
    while ($row = mysqli_fetch_array($query_get_paymentgroup_old)) {
        $memberIds[] = $row['memberId'];
    }

    // Cập nhật lại totalLoss của các thành viên
    foreach ($memberIds as $memberId) {
        $sql_get_member = "SELECT * FROM member WHERE memberId = '$memberId' LIMIT 1";
        $query_get_member = mysqli_query($mysqli, $sql_get_member);
        $member = mysqli_fetch_array($query_get_member);
        $totalLossOld = $member['totalLoss'] - ($spending['spendTotal'] / $spending['memberCount']);

        $sql_update_member = "UPDATE member SET totalLoss = $totalLossOld WHERE memberId = '$memberId'";
        mysqli_query($mysqli, $sql_update_member);
    }

    // Xóa những chi tiết chi tiêu cũ từ bảng paymentgroup
    $sql_delete_paymentgroup_old = "DELETE FROM paymentgroup WHERE spendGroup = '" . $spending['spendGroup'] . "'";
    mysqli_query($mysqli, $sql_delete_paymentgroup_old);

    // Thêm lại các chi tiết chi tiêu mới vào bảng paymentgroup
    foreach ($paymentGroup as $memberId) {
        $sql_insert_paymentgroup = "INSERT INTO paymentgroup(spendGroup, memberId, groupId) VALUE('" . $spending['spendGroup'] . "', '$memberId', '$groupId')";
        mysqli_query($mysqli, $sql_insert_paymentgroup);

        // Lấy ra thông tin hiện tại của thành viên
        $sql_get_member = "SELECT * FROM member WHERE memberId = '$memberId' LIMIT 1";
        $query_get_member = mysqli_query($mysqli, $sql_get_member);
        $member = mysqli_fetch_array($query_get_member);
        $totalLossNew = $member['totalLoss'] + ($spendTotal / $memberCount);

        $sql_update_member = "UPDATE member SET totalLoss = $totalLossNew WHERE memberId = '$memberId'";
        mysqli_query($mysqli, $sql_update_member);
    }

    // gửi mail
    $email_content = '<h4> Có một khoản chi vừa được thay đổi</h4>
        <p>Sửa một xíu nhé ae ^^</p>
        <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <th style="padding: 8px; border: 1px solid #dddddd;">Nội dung</th>
            <th style="padding: 8px; border: 1px solid #dddddd;">Người chi</th>
            <th style="padding: 8px; border: 1px solid #dddddd;">Số tiền</th>
            <th style="padding: 8px; border: 1px solid #dddddd;">Tham gia</th>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . $spendName . '</td>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . $member['memberName'] . '</td>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . number_format($spendTotal) . 'đ</td>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . $memberCount . '</td>
        </tr>
        </table>
        </br>
        </br>
        <h4>Thống kê số dư</h4>
        <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <th style="padding: 8px; border: 1px solid #dddddd;">Tên thành viên</th>
            <th style="padding: 8px; border: 1px solid #dddddd;">Số dư</th>
        </tr>';

    $sql_get_member_info = "SELECT * FROM member";
    $query_get_member_info = mysqli_query($mysqli, $sql_get_member_info);

    while ($member = mysqli_fetch_array($query_get_member_info)) {
        $email_content .= '<tr>
            <td style="padding: 8px; border: 1px solid #dddddd; width: 120px;">' . $member['memberName'] . '</td>
            <td style="padding: 8px; border: 1px solid #dddddd;">' . number_format($member['totalExpend'] - $member['totalLoss']) . 'đ</td>
        </tr>';
    }

    $email_content .= '</table>';

    foreach ($paymentGroup as $memberId) {
        // Lấy ra thông tin hiện tại của thành viên
        $sql_get_member = "SELECT * FROM member WHERE memberId = '" . $memberId . "' LIMIT 1";
        $query_get_member = mysqli_query($mysqli, $sql_get_member);
        $member = mysqli_fetch_array($query_get_member);
        if ($member['memberEmail'] != null && $member['memberEmail'] != "") {
            sendEmail($member['memberEmail'], $email_content);
        }
    }

    // Cập nhật lại totalExpend của người chi trả
    $totalExpendNew = $totalAmount + $spendTotal;
    $sql_update_member_spending = "UPDATE member SET totalExpend = $totalExpendNew, memberNote = 'Vừa thay đổi 1 khoản chi' WHERE memberId = '$spendMember'";
    mysqli_query($mysqli, $sql_update_member_spending);

    header('Location: ../../index.php?action=spending&query=spending_list&message=success');
} else {
    foreach ($spend_ids as $spend_id) {
        // Lấy thông tin của spending cần xóa
        $sql_get_spending = "SELECT * FROM spending WHERE spendId = $spend_id";
        $query_get_spending = mysqli_query($mysqli, $sql_get_spending);
        $spending = mysqli_fetch_array($query_get_spending);

        // Lấy thông tin các payment group của spending này
        $sql_get_paymentgroup = "SELECT * FROM paymentgroup WHERE spendGroup = '" . $spending['spendGroup'] . "'";
        $query_get_paymentgroup = mysqli_query($mysqli, $sql_get_paymentgroup);

        // Lặp qua từng payment group và cập nhật lại thông tin cho từng thành viên
        while ($paymentgroup = mysqli_fetch_array($query_get_paymentgroup)) {
            $memberId = $paymentgroup['memberId'];
            $groupId = $paymentgroup['groupId'];

            // Lấy thông tin hiện tại của thành viên
            $sql_get_member = "SELECT * FROM member WHERE memberId = $memberId";
            $query_get_member = mysqli_query($mysqli, $sql_get_member);
            $member = mysqli_fetch_array($query_get_member);

            // Cập nhật lại totalLoss của thành viên
            $totalLossNew = $member['totalLoss'] - ($spending['spendTotal'] / $spending['memberCount']);
            $sql_update_member = "UPDATE member SET totalLoss = $totalLossNew WHERE memberId = $memberId";
            mysqli_query($mysqli, $sql_update_member);

            $email_content = '<h2>Có 1 khoản chi vừa bị xóa!</h2>
            <p>Sorry mình nhầm 1 xíu :))</p>
            ';
            if ($member['memberEmail'] != null && $member['memberEmail'] != "") {
                sendEmail($member['memberEmail'], $email_content);
            }
        }

        // Xóa spending
        $sql_delete_spending = "DELETE FROM spending WHERE spendId = $spend_id";
        mysqli_query($mysqli, $sql_delete_spending);

        // Xóa các payment group của spending này
        $sql_delete_paymentgroup = "DELETE FROM paymentgroup WHERE spendGroup = '" . $spending['spendGroup'] . "'";
        mysqli_query($mysqli, $sql_delete_paymentgroup);

        // Lấy thông tin hiện tại của thành viên đã thanh toán
        $sql_get_member_expend = "SELECT * FROM member WHERE memberId = '" . $spending['spendMember'] . "'";
        $query_get_member_expend = mysqli_query($mysqli, $sql_get_member_expend);
        $member_expend = mysqli_fetch_array($query_get_member_expend);

        // Cập nhật lại totalExpend của người tạm thanh toán
        $totalExpendNew = $member_expend['totalExpend'] - $spending['spendTotal'];
        $sql_update_member_spending = "UPDATE member SET totalExpend = $totalExpendNew, memberNote = 'Vừa xóa 1 khoản chi' WHERE memberId = " . $spending['spendMember'];
        mysqli_query($mysqli, $sql_update_member_spending);
    }
    header('Location: ../../index.php?action=spending&query=spending_list&message=success');
}
