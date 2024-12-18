<?php
include "koneksi.php";

date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['id_kendaraan'])) {
    $id_kendaraan = $_POST['id_kendaraan'];
    $jam_keluar = $_POST['jam_keluar'];
    $total_bayar = $_POST['total_bayar'];

    if (!isset($_SESSION['id_petugas'])) {
        die('Error: ID Petugas tidak ditemukan.');
    }
    $id_petugas = $_SESSION['id_petugas'];

    $update_kendaraan_query = "UPDATE tb_kendaraan SET jam_keluar='$jam_keluar', status='selesai', total_bayar='$total_bayar' WHERE id_kendaraan='$id_kendaraan'";
    query($update_kendaraan_query);

    $insert_laporan_query = "INSERT INTO tb_laporan_parkir (id_kendaraan, id_petugas, tanggal) 
    VALUES ('$id_kendaraan', '$id_petugas', NOW())";
    query($insert_laporan_query);

    header("Location: keluar.php");
    exit();
}

if (isset($_POST['cari_kendaraan'])) {
    $no_kendaraan = $_POST['no_kendaraan'];
    $jam_keluar = $_POST['jam_keluar'];

    $data = query("SELECT * FROM tb_kendaraan WHERE no_kendaraan='$no_kendaraan'");
    $TotalData = mysqli_num_rows($data);

    if ($TotalData == 1) {
        $obj = mysqli_fetch_object($data);
        $tampil = true;

        $jenis_kendaraan = $obj->jenis_kendaraan;
        $lamaparkir = strtotime($jam_keluar) - strtotime($obj->jam_masuk);
        $lamaparkir = ceil($lamaparkir / 3600); // Membulatkan ke atas menjadi 1 jam penuh

        if ($jenis_kendaraan == "motor") {
            $m_harga = 2000;
        } elseif ($jenis_kendaraan == "mobil") {
            $m_harga = 5000;
        } else {
            $m_harga = 0;
        }

        $totalharga = $m_harga * $lamaparkir;
        $totalBayar = $totalharga;
    } else {
        $_SESSION['notif'] = "Tidak ada data ditemukan";
        header("Location: keluar.php");
        exit();
    }
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
            <a href="tambah_admin.php">TAMBAH ADMIN</a>
            <a href="admin.php">MASUK</a>
            <a class="active" href="./keluar.php">KELUAR</a>
            <a href="list.php">LIST AKTIF</a>
            <a href="laporan.php">LAPORAN</a>
            <a href="index.php" id="logoutButton">LOGOUT</a>
        </div>

        <?php if (!isset($tampil)) { ?>
        <form action="" method="post">
            <?php if (isset($_SESSION['notif'])) { ?>
                <div class="notif">
                    <p><?= $_SESSION['notif'] ?></p>
                </div>
                <?php unset($_SESSION['notif']); } ?>

            <label for="">No Kendaraan</label>
            <input name="no_kendaraan" type="text" required>

            <label for="">Jam Keluar</label>
            <input name="jam_keluar" type="time" value="<?= date('H:i') ?>" required>

            <input type="hidden" name="cari_kendaraan">

            <button type="submit">Cari Kendaraan</button>
        </form>
        <?php } ?>

        <?php if (isset($tampil)) { ?>
        <form action="" method="POST">
            <label for="">No Kendaraan</label>
            <input type="text" disabled value="<?= htmlspecialchars($obj->no_kendaraan); ?>">

            <label for="">Jenis Kendaraan</label>
            <input type="text" disabled value="<?= htmlspecialchars($obj->jenis_kendaraan); ?>">

            <label for="">Jam Masuk</label>
            <input type="time" value="<?= htmlspecialchars($obj->jam_masuk); ?>" disabled>

            <label for="">Jam Keluar</label>
            <input type="time" value="<?= htmlspecialchars($jam_keluar); ?>" disabled>

            <input type="hidden" name="jam_keluar" value="<?= htmlspecialchars($jam_keluar); ?>">
            <label for="">Lama Parkir</label>
            <input type="text" value="<?= intval($lamaparkir); ?> Jam">

            <label for="">Total Harus di bayar</label>
            <input type="text" value="<?= htmlspecialchars($totalBayar) ?>" disabled>
            <input type="hidden" name="id_kendaraan" value="<?= htmlspecialchars($obj->id_kendaraan); ?>">
            <input type="hidden" name="total_bayar" value="<?= htmlspecialchars($totalBayar); ?>">
            <button type="submit">Selesaikan</button>
        </form>
        <?php } ?>

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
