<?php


    if(strcmp('5.0.0', phpversion()) < 0)
    {
        // PHP 5

      //  error_reporting(E_ALL + E_STRICT);      // use this for Debugging only !

        include_once('captcha/hn_captcha.class.php5');
        include_once('captcha/hn_captcha.class.x1.php5');

    }
    else
    {
        // PHP 4

        error_reporting(E_ALL);                 // use this for Debugging only !

        include_once('captcha/hn_captcha.class.php4');
        include_once('captcha/hn_captcha.class.x1.php4');

    }



?>
