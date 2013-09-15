<?php

/**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
@ini_set('display_errors','1'); @error_reporting(E_ALL);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_STRICT);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * Set a default timezone to avoid PHP5 warnings
 */
$dtmz = @date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');


// namespaces
$autoloader = 'vendor/autoload.php';
if (file_exists($autoloader)) {
    require_once $autoloader;
} else {
    die('You need to run Composer on the package to install dependencies');
}

/* EXAMPLE */

$txt_message = "Hello dude !\n\nMy line 1\nLine 2\nLine 3";
$txt_message_iso = "Hello dude !\n\nMy line 1 with special chars : é à\nLine 2\nLine 3";
$html_message = "Hello dude !\n\n<br /><table><tr><td><b>Line 1</b></td><td>Line 2</td><td>Line 3</tr></table>";
$html_message_iso = "Hello dude !\n\n<br /><table><tr><td><b>My line 1 with special chars : é à</b></td><td>Line 2</td><td>Line 3</tr></table>";
$test_adress_1 = 'piero.wbmstr@gmail.com';
$test_name_1 = 'Piero';
$test_name_1_iso = 'Piéro';
$test_adress_2 = 'pierre.cassat@gmail.com';
$test_name_2 = 'Piero2';
$test_adress_3 = 'pierrecassat@free.fr';
$test_name_3 = 'PieroFree';
$from = 'the_tester@system.fr';
$from_name = 'mister Tester';
$file = 'lorem_ipsum.txt';
$subject = 'The subject of this test message ...';
$subject_iso = 'The subject of this test message with special chars : é à ...';

// Initialisation of the mail
$mail = MimeEmail\Mailer::getInstance();

// settings
$mail->setSpoolDirectory(__DIR__.'/demo/tmp');

// Adding some emails
$mail->getMessage()
    ->setFrom($from, $from_name)
    ->setTo($test_adress_1)
//    ->setSubject($subject)
    ->setSubject($subject_iso)
//    ->setText($txt_message)
    ->setText($txt_message_iso)
    ->setCc($test_adress_2, 'yo')
    ->setCc($test_adress_3, $test_name_3)
    // This will send an error : this is not an email adress
//  ->setCc('yuiuy')
    // Loading HTML content
    	// Simple HTML content
//  ->setHtml($html_message)
    	// ISO chars HTML content
    ->setHtml($html_message_iso)
    // Attah a file
    ->setAttachment($file)
    ;

// Send mails with feedback
$ok = $mail
//    ->send(1)
    ->spool(1)
    ;

// See the object
if ($ok) echo "<p>OK - Mail sent</p>";
else echo "<p>ERROR - Mail not sent!</p>";
echo "<pre>"; var_export($mail); echo "</pre>";

?>