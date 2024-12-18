<?php 
include "koneksi.php";

date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['no_kendaraan'])) {
    $no_kendaraan = $_POST['no_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $jam_masuk = $_POST['jam_masuk'];

    $x = query("INSERT INTO tb_kendaraan (id_kendaraan, no_kendaraan, jenis_kendaraan, jam_masuk, jam_keluar, status) VALUES ('', '$no_kendaraan', '$jenis_kendaraan', '$jam_masuk', '', 'belum selesai')");
    if ($x) {
        $_SESSION['notif'] = [
            'type' => 'informasi',
            'message' => 'Berhasil menambah Data.',
            'icon' => 'ℹ️',
            'button' => 'Ya'
        ];
    } else {
        $_SESSION['notif'] = [
            'type' => 'peringatan',
            'message' => 'Gagal menambah data kendaraan.',
            'icon' => '❌',
            'button' => 'Ya'
        ];
    }
    header("Location: admin.php");
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
            <a href="tambah_admin.php">TAMBAH PETUGAS</a>
            <a class="active" href="admin.php">MASUK</a>
            <a href="./keluar.php">KELUAR</a>
            <a href="list.php">LIST AKTIF</a>
            <a href="laporan.php">LAPORAN</a>
            <a href="index.php" id="logoutButton">LOGOUT</a>
        </div>

        <form action="" method="post">
            <label for="no_kendaraan">No Kendaraan</label>
            <input type="text" required name="no_kendaraan">

            <label for="jenis_kendaraan">Jenis Kendaraan</label>
            <select name="jenis_kendaraan">
                <option value="motor">Motor</option>
                <option value="mobil">Mobil</option>
            </select>

            <label for="jam_masuk">Jam Masuk</label>
            <input name="jam_masuk" type="time" value="<?= date('H:i') ?>" required>

            <button>Tambah</button>
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
                <button onclick="closeNotifModal()"><?= $_SESSION['notif']['button'] ?? '' ?></button>
            </div>
        </div>
    </div>

    <!-- Modal Logout -->
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
        // Tampilkan modal notifikasi jika ada notifikasi
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
