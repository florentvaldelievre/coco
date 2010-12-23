<?PHP


    require_once("hn_captcha.class.x1.php");
	include_once("captcha_conf.php");



?>

<?php


    //$captcha =& new hn_captcha_X1($CAPTCHA_INIT);
    $captcha =& new hn_captcha_X1($CAPTCHA_INIT, TRUE);


    if($captcha->garbage_collector_error)
    {
        // Error! (Counter-file or deleting lost images)
        echo "<p><br><b>An ERROR has occured!</b><br>Here you might send email-notification to webmaster or something like that.</p>";
    }



    switch($captcha->validate_submit())
    {

        // was submitted and has valid keys
        case 1:
            // PUT IN ALL YOUR STUFF HERE //
                    echo "<p><br>Congratulation. You will get the resource now.";
                    echo "<br><br><a href=\"".$_SERVER['PHP_SELF']."?download=yes&id=1234\">New DEMO</a></p>";
            break;


        // was submitted with no matching keys, but has not reached the maximum try's
        case 2:
            echo $captcha->display_form();
            break;


        // was submitted, has bad keys and also reached the maximum try's
        case 3:
            //if(!headers_sent() && isset($captcha->badguys_url)) header('location: '.$captcha->badguys_url);
                    echo "<p><br>Reached the maximum try's of ".$captcha->maxtry." without success!";
                    echo "<br><br><a href=\"".$_SERVER['PHP_SELF']."?download=yes&id=1234\">New DEMO</a></p>";
            break;


        // was not submitted, first entry
        default:
            echo $captcha->display_form();
            break;

    }

?>

</body>
</html>
