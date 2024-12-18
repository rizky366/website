<?php
include "koneksi.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $getData = query("SELECT * FROM tb_petugas WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($getData) > 0) {
        $row = mysqli_fetch_assoc($getData);
        $_SESSION['username'] = $username;
        $_SESSION['id_petugas'] = $row['id_petugas'];
        
        header("Location: admin.php");
        exit;
    } else {
        $_SESSION['notif'] = [
            'type' => 'peringatan',
            'message' => 'Username atau password salah.',
            'icon' => '❌',
            'button' => 'Tutup'
        ];
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>login</title>
</head>
<body>
    <div class="container">
        <h2>login</h2>
        <form action="" method="post" autocomplete="off">
            <label for="username">username</label>
            <input name="username" type="text" required>
            <label for="password">password</label>
            <input name="password" type="password" required>
            <button type="submit">submit</button>
        </form>
    </div>
    <!-- Modal Notifikasi -->
    <div id="notifModal" class="modal">
        <div class="modal-content">
            <div class="modal-header <?= $_SESSION['notif']['type'] ?? '' ?>">
                <div class="icon"><?= $_SESSION['notif']['icon'] ?? '' ?></div>
                <div class="message"><?= $_SESSION['notif']['type'] ?? '' ?></div>
            </div>
            <div class="modal-body">
                <?= $_SESSION['notif']['message'] ?? '' ?>
            </div>
            <div class="modal-footer">
                <button onclick="document.getElementById('notifModal').style.display='none'"><?= $_SESSION['notif']['button'] ?? '' ?></button>
            </div>
        </div>
    </div>

    <script>
        // Tampilkan modal jika ada notifikasi
        <?php if (isset($_SESSION['notif'])) { ?>
            document.getElementById('notifModal').style.display = 'block';
        <?php unset($_SESSION['notif']); } ?>
    </script>
</body>
</html>
</body>
</html>
