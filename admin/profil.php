<?php
require "core.php"; // Database connection and session management
include 'header.php'; // Include the header for the admin panel

// Kullanıcı bilgilerini al
$userId = $_SESSION['user_id']; // Admin kullanıcının ID'sini alın
$userQuery = $db->prepare("SELECT * FROM users WHERE id = :id");
$userQuery->bindValue(':id', $userId, PDO::PARAM_INT);
$userQuery->execute();
$user = $userQuery->fetch(PDO::FETCH_ASSOC);

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri al
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kullanıcı bilgilerini güncelle
    $updateQuery = "UPDATE users SET username = :username, email = :email";
    if (!empty($password)) {
        $updateQuery .= ", password = :password"; // Şifre varsa güncellemeye ekleyin
    }
    $updateQuery .= " WHERE id = :id";

    $updateStmt = $db->prepare($updateQuery);
    $updateStmt->bindValue(':username', $username, PDO::PARAM_STR);
    $updateStmt->bindValue(':email', $email, PDO::PARAM_STR);
    if (!empty($password)) {
        $updateStmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    }
    $updateStmt->bindValue(':id', $userId, PDO::PARAM_INT);
    $updateStmt->execute();

    // Başarı mesajı
    $successMessage = "Profiliniz başarıyla güncellendi.";
}
?>

<main class="bmd-layout-content">
    <div class="container-fluid">
        <?php include 'notification.php'; ?>
        <div class="jumbotron shade pt-5">
            <section class="content">
                <div class="row pt-4">
                    <div class="col-lg-12">
                        <h2>Profil Ayarları</h2>

                        <?php if (isset($successMessage)): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>

                        <!-- Profil Güncelleme Formu -->
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="username">Kullanıcı Adı</label>
                                <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-posta</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Yeni Şifre (isteğe bağlı)</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Yeni şifre girin">
                            </div>
                            <button type="submit" class="btn btn-success">Güncelle</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
