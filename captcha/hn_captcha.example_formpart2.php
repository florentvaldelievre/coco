<?PHP



// Please type in all needed values before run the script!

    require_once("hn_captcha.class.php");

    // ConfigArray
    $CAPTCHA_INIT = array(

            // string: absolute path (with trailing slash!) to a php-writeable tempfolder which is also accessible via HTTP!
            'tempfolder'     => $_SERVER['DOCUMENT_ROOT'].'/_tmp/',

            // string: absolute path (in filesystem, with trailing slash!) to folder which contain your TrueType-Fontfiles.
            'TTF_folder'     => dirname(__FILE__).'/fonts/',

            // mixed (array or string): basename(s) of TrueType-Fontfiles, OR the string 'AUTO'. AUTO scanns the TTF_folder for files ending with '.ttf' and include them in an Array.
            // Attention, the names have to be written casesensitive!
            //'TTF_RANGE'    => 'NewRoman.ttf',
            //'TTF_RANGE'    => 'AUTO',
            //'TTF_RANGE'    => array('actionj.ttf','bboron.ttf','epilog.ttf','fresnel.ttf','lexo.ttf','tetanus.ttf','thisprty.ttf','tomnr.ttf'),
            'TTF_RANGE'    => 'AUTO',

            'chars'          => 5,       // integer: number of chars to use for ID
            'minsize'        => 20,      // integer: minimal size of chars
            'maxsize'        => 30,      // integer: maximal size of chars
            'maxrotation'    => 25,      // integer: define the maximal angle for char-rotation, good results are between 0 and 30
            'use_only_md5'   => FALSE,   // boolean: use chars from 0-9 and A-F, or 0-9 and A-Z

            'noise'          => TRUE,    // boolean: TRUE = noisy chars | FALSE = grid
            'websafecolors'  => FALSE,   // boolean
            'refreshlink'    => TRUE,    // boolean
            'lang'           => 'en',    // string:  ['en'|'de'|'fr'|'it'|'fi'|'nl']
            'maxtry'         => 3,       // integer: [1-9]

            'badguys_url'    => '/',     // string: URL
            'secretstring'   => 'A very, very secret string which is used to generate a md5-key!',
            'secretposition' => 9        // integer: [1-32]
    );



// Extending the original class to suite some individual needs of an existing project:

class X_hn_captcha extends hn_captcha
{

    // Constructor

    function X_hn_captcha($config, $debug=FALSE, $secure=TRUE)
    {
        // call constructor of parent class
        $this->__construct($config, $debug, $secure);
    }



    // modified FormPart-Output to suite the needs of an individual form

    function my_form_part($with_refresh_button=TRUE)
    {
        $ret = '<tr><td>';
        $ret .= $this->display_form_part('image');
        $ret .= '</td><td>';
        $ret .= "Type in the {$this->chars} chars. (Valid chars are between 0-9 and {$this->usedchars})";
        $ret .= '<br><br>';
        $ret .= $this->display_form_part('input');
        $ret .= '</td></tr>';

        $ret .= '<tr><td colspan="2">';
        $ret .= '<small>' . $this->display_form_part('text_notvalid') . '</small>';
        $ret .= '</td></tr>';

        if($with_refresh_button)
        {
            $ret .= '<tr><td>';
            $ret .= 'Unreadable chars?';
            $ret .= '</td><td>';
            $ret .= 'Generate a ' . $this->display_form_part('refresh_button');
            $ret .= '</td></tr>';
        }

        return $ret;
    }



    // also a modified Version to suite individual needs
    // (Every thing is stripped out. Only one message in one language is available.
    //  It appears after the first try, if this wasn't valid.)

    function notvalid_msg()
    {
        if($this->current_try > 1) return $this->sanitized_output("This is try {$this->current_try} of {$this->maxtry}");
    }

}




// START example of existing formgeneration and validation

        // sanitize Inputs
            if(isset($_GET) && is_array($_GET)) {
                while(list($key, $value) = each($_GET))
                    $_GET["$key"] = strip_tags($value);
            }
            if(isset($_POST) && is_array($_POST)) {
                while(list($key, $value) = each($_POST))
                    $_POST["$key"] = strip_tags($value);
            }
            if(isset($_COOKIES) && is_array($_COOKIES)) {
                while(list($key, $value) = each($_COOKIES))
                    $_COOKIES["$key"] = strip_tags($value);
            }

        // generate a form
            function my_orig_form($type,$varname,$default_value='')
            {
                $ret = '';
                switch($type)
                {
                    case 'text':
                        $value = isset($_POST[$varname]) ? $_POST[$varname] : $default_value;
                        $ret = "<input type=\"text\" name=\"$varname\" value=\"$value\">\n";
                        break;
                    case 'checkbox':
                        $checked = isset($_POST[$varname]) || $default_value===1 ? ' checked' : '';
                        $ret = "<input type=\"Checkbox\" name=\"$varname\" value=\"1\"{$checked}>\n";
                        break;
                }
                return $ret;
            }
            function display_form_start()
            {
                $s = "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\">\n";
                $s .= '<table border=1 width="80%" align="center"><tr><td width="20%">&nbsp;</td><td width="80%"><small><i>(here starts the existing Form)</i></small></td>';
                $s .= '<tr><td>Type in your Name</td><td>'.my_orig_form('text','text1','').'</td></tr>';
                $s .= '<tr><td>Type in your Weight</td><td>'.my_orig_form('text','text3','').'</td></tr>';
                $s .= '<tr><td>Type in your E-Mail</td><td>'.my_orig_form('text','text2','').'</td></tr>';
                $s .= '<tr><td>Do you want receive some more Spam? ;-)</td><td>'.my_orig_form('checkbox','box1',1).'</td></tr>';
                echo $s;
            }
            function display_form_end()
            {
                $s  = "<tr><td>If you have filled all needed fields, please send us the form:</td><td><input type=\"Submit\" name=\"SEND\" value=\"SEND\"></td></tr>";
                $s .= '<tr><td>&nbsp;</td><td><small><i>here ends the existing Form</i></small></td></tr></table></form>';
                echo $s;
            }

// END example of existing formgeneration and validation

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<TITLE>PHP-Captcha-Class :: DEMO</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">

<style type="text/css">
<!--

/*********************************
 *
 *    globale HTML Styles
 *
 */
    a:link
    {
        color: #0079C5;
        background: transparent;
        text-decoration: none;
    }
    a:visited
    {
        color: #5DA3ED;
        background: transparent;
        text-decoration: none;
    }
    a:hover,
    a:active,
    a:focus
    {
        color: #cd3021;
        background: transparent;
        text-decoration: underline;
    }

    html,
    body
    {
        margin-top: 20px;
        margin-bottom: 20px;
        margin-left: 20px;
        margin-right: 20px;
        padding-top: 0px;
        padding-bottom: 0px;
        padding-left: 0px;
        padding-right: 0px;
    }

    body
    {
        background-color: #FFFFFF;
        color: #000000;
        font-family: Verdana, Helvetica, Arial, sans-serif;
    }

    h3
    {
        margin-left: 30px;
        margin-right: 20px;
        background: transparent;
        color: #222222;
        font-size: 20px;
        font-style: normal;
        font-weight: bold;
        font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
        line-height: 100%;
        letter-spacing: 1px;
    }

    p, td {
        margin-left: 20px;
        margin-right: 20px;
        font-size: 12px;
        font-style: normal;
        font-weight: normal;
        font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
        background: transparent;
        color: #000000;
    }

    .captchapict
    {
        border: none;
    }

-->
</style>
</head>
<body>
<h3>This is also a demo of hn_captcha.class.php integrated in an existing Form:</h3>

<?PHP

    $valid_postvars = array('text1','text2','text3','box1',);


    $captcha =& new X_hn_captcha($CAPTCHA_INIT, TRUE);   // with debugging turned ON
    //$captcha =& new X_hn_captcha($CAPTCHA_INIT);           // normal use

    switch($captcha->validate_submit())
    {

        // was submitted and has valid keys
        case 1:
            // PUT IN ALL YOUR STUFF HERE //
                echo "<p><br>Congratulation. The Captchatest is valid. Now we proceed the other Form-Values:</p><p>";
                foreach($valid_postvars as $v)
                {
                    if(isset($_POST[$v])) echo "$v => {$_POST[$v]}<br>";
                }
                echo "</p><p><br><a href=\"".$_SERVER['PHP_SELF']."\">New DEMO</a></p>";
            break;



        // was submitted, has bad keys and also reached the maximum try's
        case 3:
            // $captcha->hack_prevention(); // redirects to $badguys_url
                echo "<p><br>Reached the maximum try's of ".$captcha->maxtry." without success!";
                echo "<br><br><a href=\"".$_SERVER['PHP_SELF']."\">New DEMO</a></p>";
            break;



        // was submitted with no matching keys, but has not reached the maximum try's
        case 2:

        // was not submitted, (first try)
        default:
            // output the whole form
            display_form_start();
            echo "<tr><td colspan=\"2\"><small><i>(here starts the Captcha-Formpart)</i></small></td></tr>";

                // input the captcha formpart
                echo $captcha->my_form_part(TRUE);

            echo '<tr><td colspan="2"><small><i>(here ends the Captcha-Formpart)</i></small></td></tr>';
            display_form_end();
            break;

    }

?>

</body>
</html>
