<?php
/**
 * MimeMailer - PHP package to send rich MIME emails
 * Copyleft (c) 2013-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/mime-mailer>
 */

namespace MimeMailer;

use \Patterns\Abstracts\AbstractSingleton;
use \Patterns\Interfaces\OptionableInterface;
use \Library\Converter\Html2Text;
use \Library\Helper\Directory as DirectoryHelper;
use \Validator\EmailValidator;

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
class Mailer
    extends AbstractSingleton
    implements OptionableInterface
{

// --------------------
// Constants
// --------------------
    const MM_CLASSNAME = "MimeMailer package";
    const MM_CLASSVERSION = "0.1";
    const BOUNDARY_OPENER = "--";
    const BOUNDARY_CLOSER = "--";
    const BOUNDARY_PREFIX = "=_MimeMailerClass_";

// --------------------
// Statics
// --------------------
    public static $LINE_ENDING = "\n";
    public static $ADDERSSES_SEPARATOR = ", ";
    public static $HEADERS_SEPARATOR = "; ";

// --------------------
// Variables
// --------------------

    /**
     * @var array
     */
    private $errors = array();

    /**
     * @var array
     */
    private $infos = array();

    /**
     * @var array of \MimeMailer\MessageInterface objects
     */
    private $messages = array();

    /**
     * @var \MimeMailer\TransportInterface
     */
    private $transporter;

    /**
     * @var \MimeMailer\SpoolInterface
     */
    private $spooler;

    /**
     * @var int
     */
    private $sent_messages = 0;

    /**
     * @var int
     */
    private $sent_errors = 0;

    /**
     * @var array
     */
    protected $options = array(
        'headers' => array(
            'MIME-Version'=>'1.0',
            'Return-Path'=>false,
            'Reply-To'=>'no-reply@mail.class',
            'X-Sender'=>false,
            'X-Priority'=>'3',
        ),
        'defaults'=>array(
            'transporter' => '\MimeMailer\Transport\MailTransport',
            'messager' => '\MimeMailer\MimeMessage',
            'spooler' => '\MimeMailer\SpoolManager',
        ),
//        'charset' => 'iso-8859-1',
        'charset' => 'utf-8',
        'wordwrap_limit' => 78,
        'sender_mailer' => "mime@mail.class",
        'boundary' => '',
        'boundary_ctt' => '',
        'message_type' => '',
        'spool_directory' => '',
        // Redefine the sendmail executable path
        'sendmail_path' => null,
    );

    /**
     * Set to TRUE to not send the mails but test its contents
     * @var bool
     */
    protected $dry_run = false;

    /**
     * Set to TRUE to not send the mails but write them in a file
     * @var bool
     */
    protected $spool = false;

// --------------------
// Construction
// --------------------

    /**
     * Construction of a MimeEmail object
     *
     * @param array $options
     */
    protected function init(array $options = null)
    {
        $this->boot();
        if (!is_null($options)) {
            $this->setOptions(
                array_merge($this->getOptions(), $options)
            );
        }
    }

// --------------------
// OptionableInterface
// --------------------

    /**
     * Set an array of options
     *
     * @param array $options
     * @return self
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Set the value of a specific option
     *
     * @param string $name
     * @param mixed $value
     * @return self
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }

    /**
     * Get the array of options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get the value of a specific option
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }

    /**
     * Get the value of a specific option
     *
     * @param string $name
     * @return mixed
     */
    public function getDefault($name)
    {
        return isset($this->options['defaults'][$name]) ? $this->options['defaults'][$name] : null;
    }

// --------------------
// Internal boot
// --------------------

    /**
     * First initialization of the object
     *
     * @return void
     */
    protected function boot()
    {
        if (defined('PHP_EOL')) {
            self::$LINE_ENDING = PHP_EOL;
        } else {
            self::$LINE_ENDING = (strpos(PHP_OS, 'WIN') === false) ? "\n" : "\r\n";
        }
        $this->setRegistry('X-Mailer', "PHP ".PHP_VERSION." - ".self::MM_CLASSNAME." ".self::MM_CLASSVERSION, 'headers');
    }

    /**
     * Initialization before sending messages
     *
     * @return void
     */
    protected function _presendInit()
    {
        // Fournir si possible un Message-Id: conforme au RFC1036,
        // sinon SpamAssassin denoncera un MSGID_FROM_MTA_HEADER
        $sender_mailer = $this->getOption('sender_mailer');
        if (Helper::isEmail($sender_mailer)) {
            preg_match('/(@\S+)/', $sender_mailer, $domain);
            $this->setRegistry('Message-Id', '<'.time().'_'.rand().'_'.md5($this->getMessage()->get('text')).$domain[1].'>', 'headers');
        } else {
            $this->addError(
                sprintf('!! - Error in "sender" address (%s) - the message will probably be considered as a spam.', $sender_mailer)
            );
        }
    }

// --------------------
// Infos / Errors
// --------------------

    /**
     * Add error
     *
     * @param string $message
     * @return self
     */
    public function addError($message)
    {
        $this->errors[] = $message;
        return $this;
    }

    /**
     * Get the errors
     *
     * @param bool $echoable Do we have to return a string to echo ? (FALSE by default)
     * @return mixed The errors stack as an array by default, a string to display if $echoable=true
     * @return string|array
     */
    public function getErrors($echoable = false)
    {
        if (true===$echoable) {
            return join("\n<br />", $this->errors);
        } else {
            return $this->errors;
        }
    }

    /**
     * Add info
     *
     * @param string $message
     * @return self
     */
    public function addInfo($message)
    {
        $this->infos[] = $message;
        return $this;
    }

    /**
     * Get the informations
     *
     * @param bool $echoable Do we have to return a string to echo ? (FALSE by default)
     * @return mixed The errors stack as an array by default, a string to display if $echoable=true
     * @return string|array
     */
    public function getInfos($echoable = false)
    {
        if (true===$echoable) {
            return join("\n<br />", $this->infos);
        } else {
            return $this->infos;
        }
    }

// --------------------
// Setters / Getters
// --------------------

    /**
     * Set a registry entry
     *
     * @param   string  $var The entry name
     * @param   mixed   $val The entry value
     * @param   string  $section A sub-section to search the entry
     * @return void
     */
    public function setRegistry($var = null, $val = null, $section = false)
    {
        if (is_null($var)) return;
        if ($section) {
            if (!isset($this->registry[$section]))
                $this->registry[$section] = array();
            $this->registry[$section][$var] = $val;
        } else {
            $this->registry[$var] = $val;
        }
        return $this;
    }

    /**
     * Get a registry entry
     *
     * @param string $var The entry name
     * @param string $section A sub-section to search the entry
     * @param mixed $default The value returned if nothing had been found
     * @return mixed The value of the entry if found, $default otherwise
     */
    public function getRegistry($var = null, $section = false, $default = false)
    {
        if (is_null($var)) return;
        if ($section && isset($this->registry[$section])) {
            if (isset($this->registry[$section][$var])) {
                return $this->registry[$section][$var];
            } else {
                return $default;
            }
        }
        if (isset($this->registry[$var])) {
            return $this->registry[$var];
        }
        return $default;
    }

    /**
     * Build a new message
     *
     * @param \MimeMailer\MessageInterface $message
     * @return self
     */
    public function addMessage(MessageInterface $message)
    {
        $this->messages[$message->getId()] = $message;
        return $this;
    }

    /**
     * Get a message by id or current message
     *
     * If no message exists for now, it will be created using the default `messager` class.
     *
     * @param   int $id
     * @return string
     * @throws \Exception if the default `messager` class doesn't exist
     */
    public function getMessage($id = null)
    {
        if (!is_null($id)) {
            return array_key_exists($id, $this->messages) ? $this->messages[$id] : null;
        } elseif (count($this->messages)>0) {
            return current($this->messages);
        } else {
            $message_class = $this->getDefault('messager');
            if (class_exists($message_class)) {
                $this->addMessage(new $message_class);
                return current($this->messages);
            } else {
                throw new \Exception(
                    sprintf('Default message class "%s" not found!', $message_class)
                );
            }
        }
    }

    /**
     * Set a transporter
     *
     * @param \MimeMailer\TransportInterface $transporter
     * @return self
     * @throws \Exception if the default `transporter::validate()` does not return `true`
     */
    public function setTransporter(TransportInterface $transporter)
    {
        if ($transporter->validate()) {
            $this->transporter = $transporter;
        } else {
            throw new \Exception(
                sprintf('Transporter "%s" is not valid for current environment!', get_class($transporter))
            );
        }
        return $this;
    }

    /**
     * Get the transporter
     *
     * If no message exists for now, it will be created using the default `transporter` class.
     *
     * @return string
     * @throws \Exception if the default `transporter` class doesn't exist
     */
    public function getTransporter()
    {
        if (empty($this->transporter)) {
            $transport_class = $this->getDefault('transporter');
            if (class_exists($transport_class)) {
                $this->setTransporter(new $transport_class);
            } else {
                throw new \Exception(
                    sprintf('Default transport class "%s" not found!', $transport_class)
                );
            }
        }
        return $this->transporter;
    }

    /**
     * Set a spooler manager
     *
     * @param \MimeMailer\SpoolInterface $spooler
     * @return self
     */
    public function setSpooler(SpoolInterface $spooler)
    {
        $this->spooler = $spooler;
        return $this;
    }

    /**
     * Get the spooler
     *
     * If no message exists for now, it will be created using the default `spooler` class.
     *
     * @return string
     * @throws \Exception if the default `spooler` class doesn't exist
     */
    public function getSpooler()
    {
        if (empty($this->spooler)) {
            $spool_class = $this->getDefault('spooler');
            if (class_exists($spool_class)) {
                $this->setSpooler(new $spool_class);
            } else {
                throw new \Exception(
                    sprintf('Default spool class "%s" not found!', $spool_class)
                );
            }
        }
        return $this->spooler;
    }

    /**
     * Make a dry run of the class : no mail will be sent
     *
     * @param bool $dry Activate dry run or not
     * @return self
     */
    public function setDryRun($dry = true)
    {
        $this->dry_run = $dry;
        return $this;
    }

    /**
     * Get the dry run value
     *
     * @return bool
     */
    public function getDryRun()
    {
        return (bool) $this->dry_run;
    }

    /**
     * Is it dry run?
     *
     * @return bool
     */
    public function isDryRun()
    {
        return true===$this->dry_run;
    }

    /**
     * Activate emails spooling
     *
     * @param bool $spool Activate spool or not
     * @return self
     */
    public function setSpool($spool = true)
    {
        $this->spool = $spool;
        return $this;
    }

    /**
     * Get the spool value
     *
     * @return bool
     */
    public function getSpool()
    {
        return (bool) $this->spool;
    }

    /**
     * Is it spooling?
     *
     * @return bool
     */
    public function isSpool()
    {
        return true===$this->spool;
    }

    /**
     * Set the spooled mails directory
     *
     * @param string $dir The directory where to create spooled mails files
     * @return self
     */
    public function setSpoolDirectory($dir)
    {
        $this->spool_dir = $dir;
        return $this;
    }

    /**
     * Get the spooled mails directory
     *
     * @return string
     */
    public function getSpoolDirectory()
    {
        return $this->spool_dir;
    }

// --------------------
// Sending
// --------------------

    /**
     * Messages sender
     *
     * @param bool $return_info Do we have to return an information about sending ?
     * @return bool|mixed
     */
    public function send($return_info = false)
    {
        $this->_presendInit();

        $msg = $this->getMessage()
            ->buildMessage()
            ->getMessage();

        // Then we send one by one
        if (false===$this->dry_run) {
            foreach ($this->getMessage()->get('to') as $set) {
                if (!empty($set) && is_array($set)) {
                    foreach ($set as $name=>$mail) {
                        if (is_numeric($name)) $name = $mail;
                        if (true===$this->spool) {
                            if (true===$this->spoolMessage($mail,$this->getMessage()->get('subject'),'',$msg)) {
                                $this->addInfo(
                                    sprintf('Spooling message to send to "%s".', $mail)
                                );
                            } else {
                                $this->addError(
                                    sprintf('!! - Error while spooling message to send to "%s"!', $mail)
                                );
                            }
                        } else {
                            if (false===$this->sendMessage($mail,$this->getMessage()->get('subject'),'',$msg)) {
                                $this->addError(
                                    sprintf('!! - The message can not be sent to "%s"!', $mail)
                                );
                                $this->sent_errors++;
                            } else {
                                $this->addInfo(
                                    sprintf('Message sent to "%s".', $mail)
                                );
                                $this->sent_messages++;
                            }
                        }
                    }
                }
            }
        } else {
            $this->addInfo('DryRun : no mail will be sent');
        }

        // errors ? infos ?
        if ($this->sent_errors>0) {
            $msg = "Error - The message(s) can not been sent ... Check errors pile!";
            $this->addInfo($msg);
            $this->addError($msg);
        } else {
            $msg = "OK - The message(s) have been sent ...";
            $this->addInfo($msg);
        }

        // return
        if (true===$return_info) {
            return $msg;
        }
        return $this->sent_messages>0;
    }

    /**
     * Messages spooler : prepare the whole content and write it in a file
     *
     * @param bool $return_info Do we have to return an information about sending ?
     * @return mixed
     */
    public function spool($return_info = false)
    {
        $this->setSpool(true);
        return $this->send($return_info);
    }

    /**
     * Messages sender : prepare the whole content and send the e-mail
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $additional_headers
     * @param string $additional_parameters
     * @return mixed
     */
    protected function sendMessage($to, $subject, $message, $additional_headers = '', $additional_parameters = '')
    {
        return $this->getTransporter()
            ->transport($to, $subject, $message, $additional_headers, $additional_parameters);
    }

    /**
     * Messages spooler : prepare the whole content and write it in a file
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $additional_headers
     * @param string $additional_parameters
     * @return mixed
     * @throws \Exception if `spool_dir` is not defined
     */
    protected function spoolMessage($to, $subject, $message, $additional_headers = '', $additional_parameters = '')
    {
        if (empty($this->spool_dir)) {
            throw new \Exception('You must define a spool directory to spool emails!');
        }
        $contents = array(
            'to'=>$to,
            'subject'=>$subject,
            'message'=>$message,
            'additional_headers'=>$additional_headers,
            'additional_parameters'=>$additional_parameters
        );
        return $this->getSpooler()
            ->setSpoolDirectory($this->spool_dir)
            ->addMessageToSpool($this->getMessage()->getId(), $contents, false);
    }

}

/* EXAMPLE */
/*
ini_set('display_errors','1'); error_reporting(E_ALL ^ E_NOTICE);
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
$file = 'inc/lorem_ipsum.txt';
$subject = 'The subject of this test message ...';
$subject_iso = 'The subject of this test message with special chars : é à ...';

// Initialisation of the mail
// standard simple mail
//$mail = new MimeEmail($from_name, $from, $test_adress_1, $subject, $txt_message);
// mail with ISO chars
$mail = new MimeEmail($from_name, $from, $test_adress_1, $subject_iso, $txt_message_iso);

// Adding some emails
$mail->setCc($test_adress_2, 'yo');
$mail->setCc($test_adress_3, $test_name_3);

// This will send an error : this is not an email adress
//$mail->setCc('yuiuy');

// Loading HTML content
// Simple HTML content
//$mail->setHtml($html_message);
// ISO chars HTML content
$mail->setHtml($html_message_iso);

// Attah a file
$mail->setAttachment($file);

// Send mails with feedback
$ok = $mail->send(1);

// See the object
echo "<pre>"; var_export($mail); echo "</pre>";
exit;
*/

// Endfile