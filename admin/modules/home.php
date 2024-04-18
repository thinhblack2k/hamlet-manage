<?php
// Đếm số thành viên
$sql_member_list = "SELECT * FROM member ORDER BY (totalExpend - totalLoss) DESC";
$query_member_list = mysqli_query($mysqli, $sql_member_list);
$member_count = mysqli_num_rows($query_member_list);

// Đếm số lượt chi tiêu
$sql_spending_count = "SELECT * FROM spending WHERE spendingStatus = 1 ORDER BY spendDate DESC, spendId DESC";
$query_spending_count = mysqli_query($mysqli, $sql_spending_count);
$spending_count = mysqli_num_rows($query_spending_count);

// Tổng tiền chi tiêu
$sql_total_spending = "SELECT SUM(spendTotal) AS total_spending FROM spending WHERE spendingStatus = 1 ORDER BY spendDate DESC, spendId DESC";
$query_total_spending = mysqli_query($mysqli, $sql_total_spending);

if ($query_total_spending) {
    $row = mysqli_fetch_assoc($query_total_spending);
    $total_spending = $row['total_spending'];
} else {
    $total_spending = 0;
}
?>
<div class="row">
    <div class="col-lg-4 col-md-4 col-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <h3 class="box-title">Số thành viên</h3>
                    <span class="box-number color-t-yellow"><?php echo $member_count ?></span>
                    <div class="box-number-new">
                        <p>Thành viên</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <h3 class="box-title">Số lần chi tiêu</h3>
                    <span class="box-number color-t-blue"><?php echo $spending_count ?></span>
                    <div class="box-number-new">
                        <p>30 ngày qua</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <h3 class="box-title">Tổng tiền chi tiêu</h3>
                    <span class="box-number color-t-red"><?php echo number_format($total_spending) ?>đ</span>
                    <div class="box-number-new">
                        <p>30 ngày qua</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-hover table-action">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Tên</th>
                                    <th>Số dư</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                while ($row = mysqli_fetch_array($query_member_list)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td>
                                            <div class="image-cover">
                                                <img src="modules/member/uploads/<?php echo $row['memberImage'] ?>" alt="<?php echo $row['memberName'] ?>">
                                            </div>
                                        </td>
                                        <td><?php echo $row['memberName'] ?></td>
                                        <td><?php echo number_format($row['totalExpend'] - $row['totalLoss']) ?>đ</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-hover table-action">
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th>Nội dung chi</th>
                                    <th>Người chi</th>
                                    <th>Số tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $sql_spending_list = "SELECT * FROM spending WHERE spendingStatus = 1 ORDER BY spendDate DESC, spendId DESC LIMIT 7";
                                $query_spending_list = mysqli_query($mysqli, $sql_spending_list);
                                while ($row = mysqli_fetch_array($query_spending_list)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $row['spendDate'] ?></td>
                                        <td><?php echo $row['spendName'] ?></td>
                                        <td>
                                            <?php
                                            $sql_get_member_spending = "SELECT * FROM member WHERE memberId = '" . $row['spendMember'] . "' LIMIT 1";
                                            $query_get_member_spending = mysqli_query($mysqli, $sql_get_member_spending);
                                            $member = mysqli_fetch_array($query_get_member_spending);
                                            echo $member['memberName'];
                                            ?>
                                        </td>
                                        <td><?php echo number_format($row['spendTotal']) ?>đ</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>