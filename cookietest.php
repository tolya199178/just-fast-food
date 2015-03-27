

    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", true);
        header("Content-Type: text/plain");
     
        if(isset($_COOKIE['cookietest'])) {
            var_dump($_COOKIE);
        }
        else {
            $time = time();
            setcookie("cookietest", $time, $time + 3600);
            echo "Cookie set at: " . $time;
        }
    ?>

