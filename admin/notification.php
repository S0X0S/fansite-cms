<?php
// notification.php

if (isset($_GET['durum'])) {
    echo '<div class="container">'; // Bildirimler için konteyner
    switch ($_GET['durum']) {
        case 'guncellendi':
            echo '<div class="alert alert-success" role="alert">Başarıyla güncellendi.</div>';

            break;
        case 'silindi':
            echo '<div class="alert alert-warning" role="alert">Başarıyla silindi.</div>';
            break;
        case 'silme_hatasi':
            echo '<div class="alert alert-danger" role="alert">Silinirken bir hata oluştu.</div>';
            break;
case 'hata':
    $mesaj = isset($_GET['mesaj']) ? htmlspecialchars($_GET['mesaj']) : 'Bir hata oluştu.';
    echo '<div class="alert alert-danger" role="alert">' . $mesaj . '</div>';
    break;

        case 'sifirlandi':
            echo '<div class="alert alert-success" role="alert">Başarıyla sıfırlandı.</div>';
            break;
        default:
            break;
    }
    echo '</div>'; // Kapatma konteyner
}
?>
