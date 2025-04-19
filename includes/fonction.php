<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>
<?php
class Alert {
    public function message($var, $link) {
        echo "<script>
            alert('" . addslashes($var) . "');
            window.location.href='" . addslashes($link) . "';
            </script>";
    }
}
$alert = new Alert();

function getDateComplete($timestamp) {
    // Ensure Turkish locale is set
    setlocale(LC_TIME, 'tr_TR.UTF-8', 'tr_TR', 'turkish');
    // Fallback to English if Turkish locale is not available
    if (!setlocale(LC_TIME, 0)) {
        setlocale(LC_TIME, 'en_US.UTF-8');
    }

    // Format date using strftime
    return strftime("%d %B %Y %A %H:%M:%S", $timestamp);
}

class Protect {    
    public function post($var) {
        return htmlentities(htmlspecialchars(trim($var)));
    }
    
    public function get($var) {
        return htmlspecialchars($var);
    }
}
$secu = new Protect();

class Password {
    public function hashme($var) {
        return sha1($var);
    }
}
$hash = new Password();

class Redirect {
    public function url($var) {
        if (headers_sent()) {
            echo "<script language='JavaScript'>document.location.href='" . addslashes($var) . "'</script>";
        } else {
            header("Location: " . $var);
            exit;
        }
    }
}
$redirect = new Redirect();

function ago($time) {
    $diff_time = time() - $time;

    if ($diff_time < 1) {
        return 'şu anda';
    }

    $sec = array(
        31556926 => 'yıl',
        2629743.83 => 'ay',
        604800 => 'hafta',
        86400 => 'gün',
        3600 => 'saat',
        60 => 'dakika',
        1 => 'ikinci'
    );

    foreach ($sec as $sec => $value) {
        $div = $diff_time / $sec;
        if ($div >= 1) {
            $time_ago = round($div);
            $time_type = $value;
            if ($time_ago > 1 && $time_type != "ay") {
                $time_type .= " önce";
            }
            return '' . $time_ago . ' ' . $time_type;
        }
    }
}

/** 
* BBCode Parser function
**/
function BBcode($text) {
    // BBcode array
    $find = array(
        '~\[b\](.*?)\[/b\]~s',
        '~\[i\](.*?)\[/i\]~s',
        '~\[u\](.*?)\[/u\]~s',
        '~\[quote\](.*?)\[/quote\]~s',
        '~\[size=(.*?)\](.*?)\[/size\]~s',
        '~\[color=(.*?)\](.*?)\[/color\]~s',
        '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
        '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
    );
    
    // HTML tags to replace BBcode
    $replace = array(
        '<b>$1</b>',
        '<i>$1</i>',
        '<span style="text-decoration:underline;">$1</span>',
        '<pre>$1</pre>',
        '<span style="font-size:$1px;">$2</span>',
        '<span style="color:$1;">$2</span>',
        '<a href="$1">$1</a>',
        '<img src="$1" alt="" />'
    );
    
    // Replacing the BBcodes with corresponding HTML tags
    return preg_replace($find, $replace, $text);
}

/** 
* Function to convert newlines to <br>
**/
function retour($text) {
    return nl2br($text);
}

function turkcetarih($f, $zt = 'now') {  
    $z = date($f, strtotime($zt));  
    $donustur = array(  
        'Monday'    => 'Pazartesi',  
        'Tuesday'   => 'Salı',  
        'Wednesday' => 'Çarşamba',  
        'Thursday'  => 'Perşembe',  
        'Friday'    => 'Cuma',  
        'Saturday'  => 'Cumartesi',  
        'Sunday'    => 'Pazar',  
        'January'   => 'Ocak',  
        'February'  => 'Şubat',  
        'March'     => 'Mart',  
        'April'     => 'Nisan',  
        'May'       => 'Mayıs',  
        'June'      => 'Haziran',  
        'July'      => 'Temmuz',  
        'August'    => 'Ağustos',  
        'September' => 'Eylül',  
        'October'   => 'Ekim',  
        'November'  => 'Kasım',  
        'December'  => 'Aralık',  
        'Mon'       => 'Pts',  
        'Tue'       => 'Sal',  
        'Wed'       => 'Çar',  
        'Thu'       => 'Per',  
        'Fri'       => 'Cum',  
        'Sat'       => 'Cts',  
        'Sun'       => 'Paz',  
        'Jan'       => 'Oca',  
        'Feb'       => 'Şub',  
        'Mar'       => 'Mar',  
        'Apr'       => 'Nis',  
        'Jun'       => 'Haz',  
        'Jul'       => 'Tem',  
        'Aug'       => 'Ağu',  
        'Sep'       => 'Eyl',  
        'Oct'       => 'Eki',  
        'Nov'       => 'Kas',  
        'Dec'       => 'Ara',  
    );  
    
    foreach ($donustur as $en => $tr) {  
        $z = str_replace($en, $tr, $z);  
    }  
    
    if (strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) {
        $z = str_replace('Mayıs', 'May', $z);  
    }
    
    return $z;  
}
?>
