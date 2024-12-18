<?php
include "koneksi.php";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare SQL query to delete the record
    $sql = "DELETE FROM tb_petugas WHERE id_petugas = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['notif'] = 'Petugas berhasil dihapus';
    header("Location: list_petugas.php");
    exit;
}

// Fetch all petugas
$sql = "SELECT * FROM tb_petugas";
$result = query($sql);
$petugas = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <title>List Petugas</title>
</head>
<body>

    <div class="container">
        <div class="menu">
            <a href="tambah_admin.php">TAMBAH PETUGAS</a>
            <a href="admin.php">MASUK</a>
            <a href="./keluar.php">KELUAR</a>
            <a href="list.php">LIST AKTIF</a>
            <a href="laporan.php">LAPORAN</a>
            <a href="index.php" id="logoutButton">LOGOUT</a>
        </div>

        <h1>Daftar Petugas</h1>

        <?php if (isset($_SESSION['notif'])) { ?>
            <div class="notif">
                <p><?= $_SESSION['notif'] ?></p>
            </div>
        <?php unset($_SESSION['notif']); } ?>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($petugas as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id_petugas']) ?></td>
                        <td><?= htmlspecialchars($p['username']) ?></td>
                        <td><?= htmlspecialchars($p['alamat']) ?></td>
                        <td>
                            <a href="list_petugas.php?delete_id=<?= $p['id_petugas'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">Hapus</a>
                            <a href="edit_petugas.php?id=<?= $p['id_petugas'] ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
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
