<?php
    
    $CAPTCHA_INIT = array(

            // string: absolute path (with trailing slash!) to a php-writeable tempfolder which is also accessible via HTTP!
            //'tempfolder'     => dirname(__FILE__).'/_tmp/',
    		 'tempfolder'     =>   'captcha/_tmp/',

            // string: absolute path (in filesystem, with trailing slash!) to folder which contain your TrueType-Fontfiles.
            'TTF_folder'     => dirname(__FILE__).'/fonts/',

            // mixed (array or string): basename(s) of TrueType-Fontfiles, OR the string 'AUTO'. AUTO scanns the TTF_folder for files ending with '.ttf' and include them in an Array.
            // Attention, the names have to be written casesensitive!
            //'TTF_RANGE'    => 'NewRoman.ttf',
            //'TTF_RANGE'    => 'AUTO',
            //'TTF_RANGE'    => array('actionj.ttf','bboron.ttf','epilog.ttf','fresnel.ttf','lexo.ttf','tetanus.ttf','thisprty.ttf','tomnr.ttf'),
            'TTF_RANGE'    => 'AUTO',

            'chars'          => 4,       // integer: number of chars to use for ID
            'minsize'        => 20,      // integer: minimal size of chars
            'maxsize'        => 30,      // integer: maximal size of chars
            'maxrotation'    => 20,      // integer: define the maximal angle for char-rotation, good results are between 0 and 30

            'noise'          => true,    // boolean: TRUE = noisy chars | FALSE = grid
            'websafecolors'  => FALSE,   // boolean
            'refreshlink'    => TRUE,    // boolean
            'lang'           => 'fr',    // string:  ['en'|'de']
            'maxtry'         => 5,       // integer: [1-9]

            'badguys_url'    => '/',     // string: URL
            'secretstring'   => 'ma super md5-key tres secrete!',
            'secretposition' => 24,      // integer: [1-32]

            'counter_filename'        => '',              // string: absolute filename for textfile which stores current counter-value. Needs read- & write-access!
            'prefix'                => 'hn_captcha_',   // string: prefix for the captcha-images, is needed to identify the files in shared tempfolders
            'collect_garbage_after'    => 20,             // integer: the garbage-collector run once after this number of script-calls
            'maxlifetime'            => 60              // integer: only imagefiles which are older than this amount of seconds will be deleted

    );
?>
