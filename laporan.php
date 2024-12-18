<?php
include "koneksi.php";

date_default_timezone_set('Asia/Jakarta');



$query = "SELECT lp.id_laporan_parkir, k.no_kendaraan, p.id_petugas, lp.tanggal
          FROM tb_laporan_parkir lp
          JOIN tb_kendaraan k ON lp.id_kendaraan = k.id_kendaraan
          JOIN tb_petugas p ON lp.id_petugas = p.id_petugas
          ORDER BY lp.tanggal DESC";
$data = query($query);


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
            <a href="admin.php">MASUK</a>
            <a href="keluar.php">KELUAR</a>
            <a href="list.php">LIST AKTIF</a>
            <a class="active" href="laporan.php">LAPORAN</a>
            <a href="index.php" id="logoutButton">LOGOUT</a>
        </div>

        <table width="100%" border="1" cellspacing="0">
            <tr>
                <th>No Laporan Parkir</th>
                <th>No Kendaraan</th>
                <th>ID Petugas</th>
                <th>Tanggal</th>
            </tr>

            <?php if (!empty($data)) { ?>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_laporan_parkir']) ?></td>
                        <td><?= htmlspecialchars($row['no_kendaraan']) ?></td>
                        <td><?= htmlspecialchars($row['id_petugas']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">Tidak ada data laporan parkir</td>
                </tr>
            <?php } ?>
        </table>
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
