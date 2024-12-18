<?php 
include "koneksi.php";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['alamat'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];

    // Simpan password tanpa enkripsi
    $sql = "INSERT INTO tb_petugas (username, password, alamat) VALUES ('$username', '$password', '$alamat')";
    $x = query($sql);
    if ($x) {
        $_SESSION['notif'] = [
            'type' => 'informasi',
            'message' => 'Berhasil menambah data petugas.',
            'icon' => 'ℹ️',
            'button' => 'Ya'
        ];
    } else {
        $_SESSION['notif'] = [
            'type' => 'peringatan',
            'message' => 'Gagal menambah data petugas.',
            'icon' => '❌',
            'button' => 'Ya'
        ];
    }
    header("Location: tambah_admin.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    <link rel="stylesheet" href="style.css?<?= time() ?>">
    <title>Parkir Program</title>
</head>
<body>
    <div class="container">
        <div class="menu">
            <a class="active" href="tambah_admin.php">TAMBAH PETUGAS</a>
            <a gref="admin.php" href="admin.php">MASUK</a>
            <a href="./keluar.php">KELUAR</a>
            <a href="list.php">LIST AKTIF</a>
            <a href="laporan.php">LAPORAN</a>
            <a href="index.php" id="logoutButton">LOGOUT</a>
        </div>

        <form action="" method="post">
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="alamat">Alamat</label><br>
            <input type="text" id="alamat" name="alamat" required><br><br>
            <button>TAMBAH PETUGAS</button>
        </form>

        <div class="menu">
            <a href="list_petugas.php">LIST PETUGAS</a>
        </div>
    </div>

    <!-- Modal Notifikasi -->
    <div id="notifModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
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
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <div class="modal-header konfirmasi">
                <span class="icon">⚠️</span>
                <h2>Konfirmasi</h2>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin logout?</p>
            </div>
            <div class="modal-footer">
                <button onclick="confirmLogout()">Iya</button>
                <button onclick="closeLogoutModal()">Tidak</button>
            </div>
        </div>
    </div>

    <script>
        // Tampilkan modal jika ada notifikasi
        <?php if (isset($_SESSION['notif'])) { ?>
            document.getElementById('notifModal').style.display = 'block';
        <?php unset($_SESSION['notif']); } ?>

        // Fungsi untuk menutup modal notifikasi
        function closeNotifModal() {
            document.getElementById('notifModal').style.display = 'none';
        }

        // Fungsi untuk membuka modal logout
        function openLogoutModal() {
            document.getElementById('logoutModal').style.display = 'block';
        }

        // Fungsi untuk menutup modal logout
        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        // Fungsi untuk mengkonfirmasi logout
        function confirmLogout() {
            window.location.href = 'index.php'; // Ganti 'logout.php' dengan URL logout Anda
        }

        // Event listener untuk tombol logout
        document.getElementById('logoutButton').addEventListener('click', function(event) {
            event.preventDefault();
            openLogoutModal();
        });
    </script>
</body>
</html>
