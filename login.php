<?php
session_start();
require_once('php/connect.php');

$error = '';

if (isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {

        $stmt = $conn->prepare("SELECT * FROM `admin` WHERE `username` = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password']) || $password === $row['password']) {

                $_SESSION['authen_id'] = $row['id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['status'] = $row['status'];

                $conn->query(
                    "UPDATE `admin`
                     SET `last_login` = NOW()
                     WHERE `id` = " . intval($row['id'])
                );

                header('Location: pages/dashboard');
                exit;

            } else {
                $error = "รหัสผ่านไม่ถูกต้อง";
            }

        } else {
            $error = "ไม่พบชื่อผู้ใช้นี้ในระบบ";
        }

    } else {
        $error = "กรุณากรอก Username และ Password ให้ครบถ้วน";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Admin System</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Kanit Font -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --primary: #0f172a;
            --primary-hover: #1e293b;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --focus-ring: rgba(15, 23, 42, 0.15);
            --danger-bg: #fef2f2;
            --danger-border: #fecaca;
            --danger-text: #991b1b;
            --radius-lg: 16px;
            --radius-md: 10px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body.login-page {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, rgba(203, 213, 225, 0.4) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(226, 232, 240, 0.6) 0px, transparent 50%);
            font-family: 'Kanit', sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 410px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-logo a {
            color: var(--text-main);
            font-weight: 700;
            font-size: 28px;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .login-logo a span {
            color: var(--text-muted);
            font-weight: 400;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .card-body {
            padding: 36px 32px;
        }

        .login-box-msg {
            color: var(--text-muted);
            font-size: 15px;
            text-align: center;
            margin-bottom: 24px;
            font-weight: 400;
        }

        /* Banner */
        .cred-banner {
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #334155;
            line-height: 1.6;
        }

        .cred-banner .cred-title {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-main);
        }

        .cred-banner code {
            background: #e2e8f0;
            color: #0f172a;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 600;
            font-size: 12px;
        }

        /* Error Alert */
        .alert-danger {
            background-color: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger-text);
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--text-main);
        }

        .input-group {
            display: flex;
            position: relative;
            border-radius: var(--radius-md);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }

        .form-control {
            width: 100%;
            height: 46px;
            padding: 10px 14px;
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            color: var(--text-main);
            outline: none;
            transition: all 0.2s ease;
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group-append {
            display: flex;
        }

        .input-group-text, .pw-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px;
            background: #f8fafc;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            border-left: none;
            border-top-right-radius: var(--radius-md);
            border-bottom-right-radius: var(--radius-md);
            font-size: 14px;
        }

        .pw-toggle {
            cursor: pointer;
            border: 1px solid var(--border-color);
            border-left: none;
            transition: all 0.2s ease;
        }

        .pw-toggle:hover {
            color: var(--text-main);
            background: #f1f5f9;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--focus-ring);
            z-index: 1;
        }

        /* Button */
        .btn-login {
            width: 100%;
            height: 46px;
            background: var(--primary);
            border: none;
            color: #ffffff;
            font-family: 'Kanit', sans-serif;
            font-size: 15px;
            font-weight: 500;
            border-radius: var(--radius-md);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.1);
            margin-top: 8px;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(15, 23, 42, 0.15);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
        }

        .login-footer a {
            color: var(--text-muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .login-footer a:hover {
            color: var(--text-main);
        }
    </style>
</head>

<body class="login-page">

<div class="login-box">

    <div class="login-logo">
        <a href="#">Admin <span>System</span></a>
    </div>

    <div class="card">
        <div class="card-body">

            <p class="login-box-msg">ลงชื่อเข้าสู่ระบบจัดการข้อมูล</p>

            <div class="cred-banner">
                <span class="cred-title">
                    <i class="fa-solid fa-circle-info"></i>
                    ข้อมูลสำหรับเข้าใช้งาน
                </span>
                Username : <code>test</code><br>
                Password : <code>123456789</code>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <form action="" method="post" autocomplete="on">

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group">
                        <input
                            id="username"
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="กรอกชื่อผู้ใช้"
                            required
                            autocomplete="username"
                            value="<?php echo htmlspecialchars($_POST['username'] ?? 'test'); ?>"
                        >
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa-regular fa-user"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="กรอกรหัสผ่าน"
                            required
                            autocomplete="current-password"
                            value="123456789"
                        >
                        <div class="input-group-append">
                            <button
                                type="button"
                                class="pw-toggle"
                                onclick="togglePassword()"
                                aria-label="Toggle password"
                            >
                                <i class="fa-regular fa-eye" id="pw-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-login">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>เข้าสู่ระบบ</span>
                </button>

            </form>

            <div class="login-footer">
                <?php if (!empty($github_url)): ?>
                    <a href="<?php echo htmlspecialchars($github_url); ?>" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-github"></i>
                        <span>View Source on GitHub</span>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('pw-eye');
    const isPassword = input.type === 'password';

    input.type = isPassword ? 'text' : 'password';
    icon.className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
}
</script>

</body>
</html>