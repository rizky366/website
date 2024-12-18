<?php
include "koneksi.php";

// Initialize variables
$error = "";
$success = "";

// Get officer ID from URL
$id_petugas = $_GET['id'];

// Fetch officer data from database
$sql = "SELECT * FROM tb_petugas WHERE id_petugas = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_petugas);
$stmt->execute();
$result = $stmt->get_result();
$petugas = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $alamat = trim($_POST['alamat']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($username) || empty($alamat)) {
        $error = "Username dan Alamat harus diisi.";
    } elseif (!empty($password) && strlen($password) < 6) {
        $error = "Password harus memiliki minimal 6 karakter.";
    } else {
        // Proceed with updating the data
        if (!empty($password)) {
            $sql = "UPDATE tb_petugas SET username = ?, alamat = ?, password = ? WHERE id_petugas = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("sssi", $username, $alamat, $password, $id_petugas);
        } else {
            $sql = "UPDATE tb_petugas SET username = ?, alamat = ? WHERE id_petugas = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("ssi", $username, $alamat, $id_petugas);
        }

        if ($stmt->execute()) {
            $success = "Petugas berhasil diperbarui";
            $_SESSION['notif'] = $success;
            header("Location: list_petugas.php");
            exit;
        } else {
            $error = "Terjadi kesalahan saat memperbarui data.";
        }

        $stmt->close();
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
    <title>Edit Petugas</title>
</head>
<body>

    <div class="container">
        <div class="menu">
            <a href="tambah_admin.php">TAMBAH ADMIN</a>
            <a href="admin.php">MASUK</a>
            <a href="./keluar.php">KELUAR</a>
            <a href="list.php">LIST AKTIF</a>
            <a href="laporan.php">LAPORAN</a>
            <a href="index.php" id="logoutButton">LOGOUT</a>
        </div>

        <h1>Edit Petugas</h1>

        <?php if (!empty($error)) { ?>
            <div class="notif error">
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php } ?>

        <?php if (!empty($success)) { ?>
            <div class="notif success">
                <p><?= htmlspecialchars($success) ?></p>
            </div>
        <?php } ?>

        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($petugas['username']) ?>" required><br>
            <label for="alamat">Alamat:</label>
            <input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($petugas['alamat']) ?>" required><br>
            <label for="password">Password (Kosongkan Jika Tidak Ingin Diganti):</label>
            <input type="password" name="password" id="password"><br>
            <button>update</button>
            <a href="list_petugas.php">Kembali</a>
        </form>
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
