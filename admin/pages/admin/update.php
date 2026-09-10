<?php 
include_once('../authen.php');

if (isset($_POST['submit'])) {
    $id = intval($_POST['id'] ?? 0);
    $first_name = $conn->real_escape_string(trim($_POST['first_name'] ?? ''));
    $last_name = $conn->real_escape_string(trim($_POST['last_name'] ?? ''));
    $status = $conn->real_escape_string($_POST['status'] ?? 'admin');

    if ($id > 0) {
        $sql = "UPDATE `admin` SET `first_name` = '$first_name', `last_name` = '$last_name', `status` = '$status', `updated_at` = NOW() WHERE `id` = $id";
        if ($conn->query($sql)) {
            echo '<script>alert("บันทึกการแก้ไขเรียบร้อยแล้ว (Finished Updating!)"); window.location="index.php";</script>';
        } else {
            echo '<script>alert("เกิดข้อผิดพลาดในการอัปเดตข้อมูล: ' . $conn->error . '"); window.location="index.php";</script>';
        }
    } else {
        echo '<script>alert("ข้อมูลไม่ถูกต้อง"); window.location="index.php";</script>';
    }
} else {
    header('Location: index.php');
}
exit;
?>