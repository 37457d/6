<?php include_once('../authen.php') ?> 
<?php
if (isset($_POST['submit'])) { # เช็คว่ามีการกดปุ่ม submit หรือไม่
    $sql_check_username = "SELECT * FROM `admin` WHERE `username` = '" . $_POST['username'] . "' "; #check username in database
    $check_username = $conn->query($sql_check_username);
    if (!$check_username->num_rows) { # เช็คว่ามี username นี้อยู่ในฐานข้อมูลหรือไม่ ถ้าไม่มีให้ทำการ insert ข้อมูลลงไป
        $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT); # เข้ารหัส password ก่อนทำการ insert ลงฐานข้อมูล
        $sql = "INSERT INTO `admin` (`first_name`, `last_name`, `username`, `password`, `status`, `last_login`, `updated_at`, `creat_at`) 
                    VALUES ('" . $_POST['first_name'] . "', 
                            '" . $_POST['last_name'] . "', 
                            '" . $_POST['username'] . "', 
                            '" . $hashed . "', 
                            '" . $_POST['status'] . "',
                            '" . date("Y-m-d H:i:s") . "', 
                            '" . date("Y-m-d H:i:s") . "', 
                            '" . date("Y-m-d H:i:s") . "');";
        $result = $conn->query($sql);
        if ($result) {
            echo '<script> alert("Finished Creating!")</script>';
            header('Refresh:0; url=index.php');
        } else {
            echo '<script> alert("Creating Error!")</script>';
            header('Refresh:0; url=index.php');
        }
    } else {
        echo '<script> alert("Username is already exists!")</script>';
        header('Refresh:0; url=form-create.php');
    }
} else {
    header('Refresh:0; url=index.php');
}

?>