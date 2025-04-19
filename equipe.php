<?php
require "includes/config.php";
require "includes/header.php";
require "includes/alerte.php";


$db->exec("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_general_ci'");
?>
<div class="container" style="margin-top:20px;">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <?php
        try {
          $ranks_query = $db->query("SELECT id, name, level FROM rank");
          if (!$ranks_query) {
            throw new Exception("Rütbe sorgusu başarısız: " . $db->errorInfo()[2]);
          }
          $ranks = [];
          while ($rank = $ranks_query->fetch(PDO::FETCH_ASSOC)) {
            $ranks[$rank['level']] = $rank['name']; // level ile name eşleştir
          }

          // Bölüm tanımlamaları (level değerlerine göre)
          $sections = [
            'Yönetim' => [8, 9, 10, 11, 12],
            'Yönetici' => [5, 6, 7],
            'Yazar' => [3, 4]
          ];

          foreach ($sections as $section_name => $staff_levels) {
        ?>
            <div class="panel-body" id="body-panel">
              <div class="panel-heading" id="bg-panel"><?= htmlspecialchars($section_name) ?></div>
              <div style="margin-top:13px;"></div>
              <?php
              // Kullanıcıları staff (level) değerlerine göre çek
              $placeholders = implode(',', array_fill(0, count($staff_levels), '?'));
              $users_query = $db->prepare("SELECT id, username, staff 
                                          FROM users 
                                          WHERE staff IN ($placeholders) 
                                          ORDER BY staff DESC");
              $users_query->execute($staff_levels);
              $users = $users_query->fetchAll(PDO::FETCH_ASSOC);

              if (empty($users)) {
                echo '<div class="alert alert-info">Bu bölüm yetkili yok.</div>';
              } else {
                foreach ($users as $user) {
                  $rank_name = isset($ranks[$user['staff']]) ? $ranks[$user['staff']] : 'Bilinmeyen Rütbe';
              ?>
                  <div class="schedule-comment" style="float:left">
                    <div class="habbo-comment">
                      <img style="margin-bottom:10px; margin-left:10px;" 
                           src="https://www.habbo.com.tr/habbo-imaging/avatarimage?hb=image&user=<?= htmlspecialchars($user['username']) ?>&headonly=1&direction=2&head_direction=3&action=&gesture=&size=m" 
                           alt="<?= htmlspecialchars($user['username']) ?> avatar"
                           onerror="this.src='/images/default-avatar.png'">
                      <div class="info-habbo-comment">
                        <b><?= htmlspecialchars($user['username']) ?></b>
                        <br>
                        <span style="color: red;">
                          <?= htmlspecialchars($rank_name) ?>
                        </span>
                      </div>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
            </div>
        <?php
          }
        } catch (Exception $e) {
          echo '<div class="alert alert-danger">Hata: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php require "includes/footer.php"; ?>