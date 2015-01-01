<?php
/**
 * This file is part of the MimeMailer package.
 *
 * Copyleft (ↄ) 2013-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/mime-mailer>.
 */

namespace MimeMailer;

use \Library\Converter\Html2Text;

/**
 * @todo Cite all RFCs for each header field
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
class MimeMessage
    extends AbstractMailerAware
    implements MessageInterface
{

    /**
     * @var array
     */
    protected $from;
    
    /**
     * @var array
     */
    protected $to;
    
    /**
     * @var array
     */
    protected $cc;
    
    /**
     * @var array
     */
    protected $bcc;
    
    /**
     * @var string
     */
    protected $attachment;
    
    /**
     * @var string
     */
    protected $subject;
    
    /**
     * @var string
     */
    protected $text;
    
    /**
     * @var string
     */
    protected $html;
    
    /**
     * @var int
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $message;
    
    /**
     * @var array Set of clearing values
     */
    static $clearings = array(
        'from'=>'',
        'to'=>array(),
        'cc'=>array(),
        'bcc'=>array(),
        'attachment'=>array(),
        'header'=>'',
        'subject'=>'',
        'text'=>'',
        'html'=>'',
        'id'=>null
    );

// --------------------
// Construction
// --------------------

    /**
     * Construction of a MimeEmail object
     *
     * @param string $from_name
     * @param string $from_mail
     * @param string|array $to
     * @param string $subject
     * @param string $message
     */
    public function __construct($from_name = '', $from_mail = null, $to = null, $subject = null, $message = null) 
    {
        $this->_init();
        if (!is_null($from_mail)) $this->setFrom($from_mail, $from_name);
        if (!is_null($to)) $this->setTo($to);
        if (!is_null($subject)) $this->setSubject($subject);
        if (!is_null($message)) $this->setText($message);
    }
    
    /**
     * First initialization of the object
     *
     * @return void
     */
    protected function _init()
    {
        foreach (self::$clearings as $var=>$val) {
            $this->{$var} = $val;
        }
        if (is_null($this->id)) {
            $this->id = uniqid(time());
        }
    }
    
    /**
     * Initialization before sending messages
     *
     * @return void
     */
    protected function _buildInit()
    {
        $this->clear('message');
    
        $this->getMailer()
            ->setRegistry('boundary', $this->makeBoundary())
            ->setRegistry('boundary_ctt', $this->makeBoundary());
    
        // message type
        if (strlen($this->text)>0 && count($this->attachment)>0) {
            $this->getMailer()->setRegistry('message_type', 'multipart/mixed');
        } elseif (strlen($this->text)>0 && strlen($this->html)>0 && count($this->attachment)==0) {
            $this->getMailer()
                ->setRegistry('message_type', 'multipart/alternative')
                ->setRegistry('boundary_ctt', $this->getMailer()->getRegistry('boundary'));
        } else {
            $this->getMailer()->setRegistry('message_type', 'text/plain');
        }
    }

// --------------------
// Getters/Setters/Clearers
// --------------------

    /**
     * Global setter
     *
     * @param string $name
     * @param mixed $val
     * @return self
     */
    public function set($name, $val) 
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $val;
        }
        return $this;
    }
    
    /**
     * Global getter
     *
     * @param string $name
     * @return mixed
     */
    public function get($name) 
    {
        return property_exists($this, $name) ? $this->{$name} : null;
    }
    
    /**
     * Global variable clearer
     *
     * @param string $name
     * @return self
     */
    public function clear($name = null)
    {
        if (!is_null($name)) {
            $name = strtolower($name);
            if (array_key_exists($name, self::$clearings)) {
                $this->{$name} = self::$clearings[$self::$clearings];
            }
        } else {
            foreach (self::$clearings as $n=>$v) {
                $this->{$n} = $v;
            }
        }
        return $this;
    }
    
    /**
     * Get a fromated address info (name <email>) for `$name` field
     *
     * @param string $name
     * @return string
     */
    public function getFormated($name) 
    {
        $field_value = $this->get($name);
        return is_array($field_value) ? Helper::mailListTagger($field_value) : $field_value;
    }
    
    /**
     * Get message ID
     *
     * @return string
     */
    public function getId() 
    {
        return $this->id;
    }
    
    /**
     * Set From field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @param bool $reply Set the "reply-to" to the same address ? (default is TRUE)
     * @return self
     * @see \MimeMailer\MimeEmail::checkPeopleArgs
     */
    public function setFrom($mail = '', $name = null, $reply = true) 
    {
        $mail = trim($mail);
        if (strlen($mail) && Helper::isEmail($mail)) {
            $this->from = !empty($name) ? array($name=>$mail) : array($mail);
            $this->getMailer()->setRegistry('Return-Path', '<'.$mail.'>', 'headers');
            $this->getMailer()->setRegistry('X-Sender', $mail, 'headers');
            if ($reply) {
                $this->setReplyTo($mail,$name);
            }
        }
        return $this;
    }
    
    /**
     * Set To field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @return self
     * @see \MimeMailer\MimeEmail::checkPeopleArgs
     */
    public function setTo($mail = '', $name = null) 
    {
        $this->to = Helper::deduplicate(
            array_merge($this->to, call_user_func_array(array('\MimeMailer\Helper', 'checkPeopleArgs'), func_get_args()))
        );
        return $this;
    }
    
    /**
     * Set Cc field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @return self
     * @see \MimeMailer\MimeEmail::checkPeopleArgs
     */
    public function setCc($mail = '', $name = null) 
    {
        $this->cc = Helper::deduplicate(
            array_merge($this->cc, call_user_func_array(array('\MimeMailer\Helper', 'checkPeopleArgs'), func_get_args()))
        );
        return $this;
    }
    
    /**
     * Set Bcc field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @return self
     * @see \MimeMailer\MimeEmail::checkPeopleArgs
     */
    public function setBcc($mail = '', $name = null) 
    {
        $this->bcc = Helper::deduplicate(
            array_merge($this->bcc, call_user_func_array(array('\MimeMailer\Helper', 'checkPeopleArgs'), func_get_args()))
        );
        return $this;
    }
    
    /**
     * Set mail file attachment
     *
     * @param string|array $file The file or files to attach
     * @param bool $clear Clear a set content first ? (default is to append a content)
     * @return self
     */
    public function setAttachment($file = '', $clear = false) 
    {
        if (true===$clear) {
            $this->clear('text');
        }
        if (is_array($file)) {
            foreach($file as $_f) {
                if (file_exists($_f)) {
                    $this->attachment[] = $_f;
                }
            }
        } else {
            if (file_exists($file)) {
                $this->attachment[] = $file;
            }
        }
        return $this;
    }
    
    /**
     * Set mail object
     *
     * @param string $subject The subject content
     * @param bool $clear Clear a set content first ? (default is to append a content)
     * @return self
     */
    public function setSubject($subject = '', $clear = false) 
    {
        if (true===$clear) {
            $this->clear('subject');
        }
        $this->subject = $subject;
        return $this;
    }
    
    /**
     * Set plain text version
     *
     * If $text='auto', the text version will be generated from the HTML content
     *
     * @param string $text The plain text content or keyword 'auto' to auto-generate it from the HTML content
     * @param bool $clear Clear a set content first ? (default is to append a content)
     * @return self
     */
    public function setText($text = '', $clear = false)
    {
        if (true===$clear) {
            $this->clear('text');
        }
        if ('auto'==$text) {
            if (!empty($this->html)) {
                $html_content = preg_replace("/.*<body[^>]*>|<\/body>.*/si", "", $this->html);
                $this->text .= Helper::formatText( Helper::html2text($html_content) );
            }
        } else {
            $this->text .= Helper::formatText($text);
        }
        return $this;
    }
    
    /**
     * Set HTML version
     *
     * @param string $html The HTML content
     * @param bool $clear Clear a set content first ? (default is to append a content)
     * @return self
     */
    public function setHtml($html = '', $clear = false) 
    {
        if (true===$clear) {
            $this->clear('text');
        }
        $this->html .= Helper::formatText($html, 'ascii');
        return $this;
    }
    
    /**
     * Set Reply-To header field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @return self
     */
    public function setReplyTo($mail = '', $name = null) 
    {
        if (strlen($mail) && Helper::isEmail($mail)) {
            if (!empty($name)) {
                $_m = Helper::mailTagger($mail, $name);
            } else {
                $_m = $mail;
            }
            $this->getMailer()->setRegistry('Reply-To', $_m, 'headers');
        }
        return $this;
    }
    
    /**
     * Set Foolowup-To header field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @return self
     */
    public function setFollowupTo($mail = '', $name = null) 
    {
        if (strlen($mail) && Helper::isEmail($mail)) {
            if (!empty($name)) {
                $_m = Helper::mailTagger($mail, $name);
            } else {
                $_m = $mail;
            }
            $this->getMailer()->setRegistry('Followup-To', $_m, 'headers');
        }
        return $this;
    }
    
    /**
     * Set Errors-To header field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @return self
     */
    public function setErrorsTo($mail = '', $name = null) 
    {
        if (strlen($mail) && Helper::isEmail($mail)) {
            if (!empty($name)) {
                $_m = Helper::mailTagger($mail, $name);
            } else {
                $_m = $mail;
            }
            $this->getMailer()->setRegistry('Errors-To', $_m, 'headers');
        }
        return $this;
    }
    
    /**
     * Set Disposition-Notification-To header field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @return self
     */
    public function setDispositionNotificationTo($mail = '', $name = null) 
    {
        if (strlen($mail) && Helper::isEmail($mail)) {
            if (!empty($name)) {
                $_m = Helper::mailTagger($mail, $name);
            } else {
                $_m = $mail;
            }
            $this->getMailer()->setRegistry('Disposition-Notification-To', $_m, 'headers');
        }
        return $this;
    }
    
    /**
     * Set Abuse-Reports-To header field
     *
     * @param string/array $mail
     * @param string/bool $name
     * @return self
     */
    public function setAbuseReportsTo($mail = '', $name = null) 
    {
        if (strlen($mail) && Helper::isEmail($mail)) {
            if (!empty($name)) {
                $_m = Helper::mailTagger($mail, $name);
            } else {
                $_m = $mail;
            }
            $this->getMailer()
                ->setRegistry('Abuse-Reports-To', $_m, 'headers')
                ;
        }
        return $this;
    }
    
    /**
     * Set Return-Receipt-To header field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @return self
     */
    public function setReturnReceiptTo($mail = '', $name = null) 
    {
        if (strlen($mail) && Helper::isEmail($mail)) {
            if (!empty($name)) {
                $_m = Helper::mailTagger($mail, $name);
            } else {
                $_m = $mail;
            }
            $this->getMailer()->setRegistry('Return-Receipt-To', $_m, 'headers');
        }
        return $this;
    }
    
    /**
     * Get sent built message
     *
     * @return string
     */
    public function getMessage() 
    {
        return $this->message;
    }

// --------------------
// Sending
// --------------------

    /**
     * Message builder
     *
     * @return self
     */
    public function buildMessage()
    {
        $this->_buildInit();

        // From header
        if (is_array($this->from) && count($this->from)>0) {
            $from = null;
            while (is_null($from)==true) {
                foreach($this->from as $n=>$m) {
                    $from = array($n=>$m);
                }
            }
            $this->from = $from;
        }
        if (count($this->from)==0) {
            $this->getMailer()->addError('No sender setted!');
        } else {
            $this->message .= Helper::listAddresses($this->from, 'from');
        }

        // To header
        if (count($this->to)>0) {
            $this->message .= Helper::listAddresses($this->to, 'to');
        }

        // CC header
        if (count($this->cc)>0) {
            $this->message .= Helper::listAddresses($this->cc, 'cc');
        }

        // BCC header
        if (count($this->bcc)>0) {
            $this->message .= Helper::listAddresses($this->bcc, 'bcc');
        }

        // Headers
        foreach ($this->getMailer()->getRegistry('headers') as $entry=>$v_entry) {
            if (isset($v_entry)) {
                $this->message .= Helper::headerTagger($entry,$v_entry).Mailer::$LINE_ENDING;
            }
        }
        $bound = 0;

        // Mail type
        $type = $this->getMailer()->getRegistry('message_type');
        if (!is_null($type) && $type!='text/plain') {
            $bound = 1;
            $this->message .= Helper::headerTagger("Content-Type",$type,
                array('boundary'=>$this->getMailer()->getRegistry('boundary'))).Mailer::$LINE_ENDING;
            $this->message .= "This is a multi-part message in MIME format.".Mailer::$LINE_ENDING;
            if ($type == 'multipart/mixed') {
                $this->message .= Mailer::$LINE_ENDING.Mailer::BOUNDARY_OPENER.$this->getMailer()->getRegistry('boundary').Mailer::$LINE_ENDING;
                $this->message .= Helper::headerTagger("Content-Type","multipart/alternative",
                    array('boundary'=>$this->getMailer()->getRegistry('boundary_ctt'))).Mailer::$LINE_ENDING;
            }
        }

        // Text content
        if (strlen($this->text)/* && !strlen($this->html)*/) {
            if ($bound)  {
                $this->message .= Mailer::$LINE_ENDING.Mailer::BOUNDARY_OPENER.$this->getMailer()->getRegistry('boundary_ctt').Mailer::$LINE_ENDING;
                //ne prend pas les css en compte
//                $this->message .= Helper::headerTagger("Content-Transfer-Encoding", "7bit").Mailer::$LINE_ENDING;
                $this->message .= Helper::headerTagger("Content-Transfer-Encoding", "8bit").Mailer::$LINE_ENDING;
                $this->message .= Helper::headerTagger("Content-Type", "text/plain",
                    array('charset'=>$this->getMailer()->getOption('charset'))).Mailer::$LINE_ENDING;
            }
            $this->message .= Mailer::$LINE_ENDING.$this->text;
        }

        // HTML content
        if (strlen($this->html)) {
            if ($bound) {
                $this->message .= Mailer::$LINE_ENDING.Mailer::$LINE_ENDING.Mailer::BOUNDARY_OPENER
                    .$this->getMailer()->getRegistry('boundary_ctt').Mailer::$LINE_ENDING;
            }
            // prend les css en compte
//            $this->message .= Helper::headerTagger("Content-Transfer-Encoding", "7bit").Mailer::$LINE_ENDING;
            $this->message .= Helper::headerTagger("Content-Transfer-Encoding", "8bit").Mailer::$LINE_ENDING;
//            $this->message .= Helper::headerTagger("Content-Transfer-Encoding", "quoted-printable").Mailer::$LINE_ENDING;
            $this->message .= Helper::headerTagger("Content-Type", "text/html",
                array('charset'=>$this->getMailer()->getOption('charset'))).Mailer::$LINE_ENDING;
            $this->message .= Mailer::$LINE_ENDING.trim($this->html, Mailer::$LINE_ENDING);
        }
        if ($bound) {
            $this->message .= Mailer::$LINE_ENDING.Mailer::BOUNDARY_OPENER
                .$this->getMailer()->getRegistry('boundary_ctt').Mailer::BOUNDARY_CLOSER.Mailer::$LINE_ENDING;
        }

        // Attachments
        /* @todo what is max ? */
        $max = 10;
        if (count($this->attachment)>0) {
            for ($i=0;$i<$max;$i++) {
                if (isset($this->attachment[$i])) {
                    $file = fread(fopen($this->attachment[$i], "r"), filesize($this->attachment[$i]));
                    $filename = basename($this->attachment[$i]);
                    $this->message .= Mailer::$LINE_ENDING.Mailer::BOUNDARY_OPENER.$this->getMailer()->getRegistry('boundary').Mailer::$LINE_ENDING;
                    $this->message .= Helper::headerTagger("Content-Type",Helper::getMimeType($filename),
                        array('name'=>$filename,'charset'=>$this->getMailer()->getOption('charset'))).Mailer::$LINE_ENDING;
                    $this->message .= Helper::headerTagger("Content-Transfer-Encoding","base64").Mailer::$LINE_ENDING;
                    $this->message .= Helper::headerTagger("Content-Disposition",'attachment',
                        array('filename'=>$filename)).Mailer::$LINE_ENDING;
                    $this->message .= Helper::headerTagger("Content-Description",$filename).Mailer::$LINE_ENDING;
                    $this->message .= Mailer::$LINE_ENDING.chunk_split(base64_encode($file));
                    $file = $filename = "";
                }
            }
            $this->message .= Mailer::$LINE_ENDING.Mailer::BOUNDARY_OPENER.$this->getMailer()->getRegistry('boundary').Mailer::BOUNDARY_CLOSER.Mailer::$LINE_ENDING;
        }

        return $this;
    }

    /**
     * Build a boundary value
     *
     * @return string The generated boundary
     */
    public function makeBoundary()
    {
        return Mailer::BOUNDARY_PREFIX.md5(uniqid(time())).'.'.$this->id;
    }

    /**
     * Make a basic substitution in the object body
     *
     * @param string $search The string to search
     * @param string $replace The string to use for replacement
     * @return string The generated body
     */
    public function substitution($search, $replace)
    {
        $this->body = str_replace($search, $replace, $this->body);
        return $this->body;
    }

}

// Endfile