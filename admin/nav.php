<?php
ob_start(); // Start output buffering

// Ensure you have a valid database connection before using $db
if (!isset($db) || !$db) {
    die('Database connection not established.');
}

// Function to get logs
function getLogs($db) {
    $stmt = $db->prepare("SELECT * FROM logs ORDER BY created_at DESC LIMIT 10");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch notifications
$notifications = getLogs($db); // Pass $db to getLogs
$notificationCount = count($notifications);

// Ensure the $user variable is defined and has 'staff' attribute
if (!isset($user) || !isset($user['staff'])) {
    die('User data not available.');
}
?>
<style>
 .imguser {
    background-position: -7px -14px;
    width: 50px;
    height: 50px;
    border-radius: 37px; 
}

/* Yüklenme Çubuğu */
.progress-bar {
    position: fixed;
    top: 20px;
    left: 20px;
    width: 0%;  /* Başlangıçta çubuk sıfır */
    height: 5px; /* Çubuğun yüksekliği */
    background-color: #4caf50; /* Çubuğun rengi */
    z-index: 9998; /* Simgenin hemen altında */
}




</style>
<body class="dark">
<!-- Yüklenme Simgesi (Spinner) -->
<div id="loading-spinner" ></div>

<!-- Diğer HTML içeriğiniz burada... -->


    <div class="bmd-layout-container bmd-drawer-f-l avam-container animated bmd-drawer-in">
        <header class="bmd-layout-header">
            <div class="navbar navbar-light bg-faded animate__animated animate__fadeInDown">
                <button class="navbar-toggler animate__animated animate__wobble animate__delay-2s" type="button" data-toggle="drawer" data-target="#dw-s1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="clearNotifications()">
                                <i class="far fa-bell fa-lg"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-right-lg">
                                <span class="dropdown-item dropdown-header">Loglar</span>
                                <div class="dropdown-divider"></div>
                                <?php if ($user['staff'] >= 9): ?> <!-- Check if user is staff level 9 or higher -->
                                    <?php foreach ($notifications as $log): ?>
                                        <a href="#" class="dropdown-item">
                                            <i class="far fa-bell c-main mr-2"></i> <?= htmlspecialchars($log['action']) ?>
                                            <span class="float-right-rtl text-muted text-sm"><?= date('H:i', strtotime($log['created_at'])) ?></span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="dropdown-item text-muted">Bu loglara erişiminiz yok.</div> <!-- Message for unauthorized users -->
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"> 
					<div class="imguser" style="background-image: url(&quot;https://www.habbo.com.tr/habbo-imaging/avatarimage?hb=image&amp;user=<?= htmlspecialchars($user['username']) ?>&amp;headonly=0&amp;direction=3&amp;head_direction=3&amp;action=&amp;gesture=sml&amp;size=m&quot;);"></div>
					
					</li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= htmlspecialchars($user['username']) ?> <!-- Display the logged-in user's name -->
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="far fa-user fa-sm c-main mr-2"></i> Profile</button>
                                <button onclick="dark()" class="dropdown-item" type="button"><i class="fas fa-moon fa-sm c-main mr-2"></i> Dark Mode</button>

                                <button class="dropdown-item" type="button" onclick="window.location.href='/xuk'">
    <i class="fas fa-sign-out-alt c-main fa-sm mr-2"></i> Sign Out
</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </header>




   
<div id="dw-s1" class="bmd-layout-drawer bg-faded">
    <div class="container-fluid side-bar-container">
        <header class="pb-0">
            <a class="navbar-brand">
                <object class="side-logo" data="./svg/logo.png"></object>
            </a>
        </header>
        <p class="side-comment">Tour</p>
<li class="side a-collapse short">
    <a href="./" class="side-item" onclick="selectMenuItem(this)">
        <i class="fas fa-language mr-1"></i>Anasayfa
    </a>
</li>





<ul class="side a-collapse short">
    <a class="ul-text" onclick="toggleMenu(this)">
        <i class="fas fa-cog mr-1"></i>Kurucu <i class="fas fa-chevron-down arrow"></i>
    </a>
    <div class="side-item-container hide animated">
        <li class="side-item"><a href="./site-settings" onclick="selectMenuItem(this)"><i class="fas fa-angle-right mr-2"></i>Site Ayarlar</a></li>
        <li class="side-item"><a href="./add_channel" onclick="selectMenuItem(this)"><i class="fas fa-angle-right mr-2"></i>Panel Sayfalar</a></li>
        <li class="side-item"><a href="./rank-permison" onclick="selectMenuItem(this)"><i class="fas fa-angle-right mr-2"></i>Panel İzinleri</a></li>
        <li class="side-item"><a href="./rank-list" onclick="selectMenuItem(this)"><i class="fas fa-angle-right mr-2"></i>Rank Listesi</a></li>
    </div>
</ul>







        <ul class="side a-collapse short" data-menu-id="yonetici">
            <a class="ul-text" onclick="toggleMenu(this)">
			<i class="fas fa-cog mr-1"></i> Yönetici <i class="fas fa-chevron-down arrow"></i></a>
            <div class="side-item-container hide animated">
                <li class="side-item"><a href="./users-rank-list" onclick="selectMenuItem(this)"><i class="fas fa-angle-right mr-2"></i>Yetkili Rank Ayarlama</a></li>
                <li class="side-item"><a href="./annonce" onclick="selectMenuItem(this)"><i class="fas fa-angle-right mr-2"></i>Duyurular</a></li>
                <li class="side-item"><a href="./catagori-list" onclick="selectMenuItem(this)"><i class="fas fa-angle-right mr-2"></i>Katagoriler</a></li>
				
            </div>
        </ul>
        <p class="side-comment">Moderasyon</p>
        <li class="side a-collapse short">
            <a href="./users-list" class="side-item" onclick="selectMenuItem(this)"><i class="fas fa-fan fa-spin mr-1"></i>Kullanıcılar Listesi</a>
        </li>
        <li class="side a-collapse short">
            <a href="logs" class="side-item" onclick="selectMenuItem(this)"><i class="fas fa-fan fa-spin mr-1"></i>Panel log</a>
        </li>
        <p class="side-comment">Yazar</p>
        <li class="side a-collapse short">
            <a href="./news" class="side-item" onclick="selectMenuItem(this)"><i class="fas fa-fan fa-spin mr-1"></i>Haberler</a>
        </li>
        <li class="side a-collapse short">
            <a href="./news-add" class="side-item" onclick="selectMenuItem(this)"><i class="fas fa-fan fa-spin mr-1"></i>Haber ekle</a>
        </li>
        <li class="side a-collapse short">
            <a href="./news-approval" class="side-item" onclick="selectMenuItem(this)"><i class="fas fa-fan fa-spin mr-1"></i>Onay bekleyenler</a>
        </li>

        <p class="side-comment">Donate / Help</p>
        <li class="side a-collapse short pb-5">
            <a href="https://www.instagram.com/hasanxuk" class="side-item" onclick="selectMenuItem(this)"><i class="fas fa-coffee mr-1"></i>Help</a>
        </li>
    </div>
</div>

<script>
   
</script>
