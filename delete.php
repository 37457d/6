<?php 
include_once('../authen.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($id == 1) {
        echo '<script>alert("ไม่อนุญาตให้ลบ Super Admin หลักของระบบ"); window.location="index.php";</script>';
        exit;
    }
    
    $sql = "DELETE FROM `admin` WHERE `id` = $id";
    if ($conn->query($sql)) {
        echo '<script>alert("ลบข้อมูลสำเร็จ (Finished Deleting!)"); window.location="index.php";</script>';
    } else {
        echo '<script>alert("เกิดข้อผิดพลาดในการลบ"); window.location="index.php";</script>';
    }
    exit;
}

header('Location: index.php');
exit;
?>