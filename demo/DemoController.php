<?php

class DemoController
{

    public $fields = array(
        'sender' => array(
            'label' => 'Sender name & email (from)',
            'fields' => array(
                'name' => array(
                    'label' => 'Sender\'s name',
                    'default'=>'TestSender',
                    'type' => 'text',
                ),
                'email' => array(
                    'label' => 'Sender\'s email',
                    'default'=>'test@sender.com',
                    'type' => 'text',
                ),
            ),
        ),
        'recipients' => array(
            'label' => 'Recipients name & email',
            'comment' => 'You can write "Name <email@address>" or "email@address" ; you can write many recipients separated by a coma"',
            'fields' => array(
                'to' => array(
                    'label' => 'Main recipients (to)',
                    'type' => 'text',
                ),
                'cc' => array(
                    'label' => 'Carbon copy recipients (cc)',
                    'type' => 'text',
                ),
                'bcc' => array(
                    'label' => 'Blind carbon copy recipients (bcc)',
                    'type' => 'text',
                ),
            ),
        ),
        'contents' => array(
            'label' => 'Email contents',
            'comment' => 'If an HTML content is defined and the plain text is empty, it will be filled with the plain text version of the HTML full content.',
            'fields' => array(
                'subject' => array(
                    'label' => 'Subject',
                    'type' => 'text',
                    'default' => 'MIME Email class test',
                ),
                'plain_text' => array(
                    'label' => 'Plain text content',
                    'type' => 'textarea',
                    'default' => 'Integer ultricies fringilla nunc. Fusce tempor augue vel tortor. Nullam at ante. Mauris faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque sodales interdum augue. Vivamus tempor viverra lacus. Mauris rutrum augue sit amet nisi. Mauris eleifend euismod sapien. In augue dui, dictum id, lobortis ac, aliquet in, libero.',
                ),
                'html' => array(
                    'label' => 'HTML content',
                    'type' => 'textarea',
                ),
            ),
        ),
        'attachments' => array(
            'label' => 'Attachments',
            'comment' => 'You can define a list of attachments, separated by a coma ; files must exist.',
            'fields' => array(
                'files' => array(
                    'label' => 'Files list',
                    'type' => 'text',
                    'default' => 'lorem_ipsum.txt',
                ),
            ),
        ),
        'options' => array(
            'label' => 'Special options',
            'fields' => array(
                'reply' => array(
                    'label' => 'Response recipients (reply-to)',
                    'type' => 'text',
                ),
                'follow' => array(
                    'label' => 'Forward recipients (followup-to)',
                    'type' => 'text',
                ),
                'errors' => array(
                    'label' => 'Errors recipients (errors-to)',
                    'type' => 'text',
                ),
                'notify' => array(
                    'label' => 'Notification recipients (notification-to)',
                    'type' => 'text',
                ),
            ),
        ),
    );

    protected $posted = array();

    public function __construct()
    {
        if (isset($_POST) && isset($_POST['mimemail'])) {
            $this->posted = $_POST['mimemail'];
        }
    }

    public function isPosted($name, $default = '')
    {
        $subname = null;
        if (strpos($name, '.')!==false) {
            list($name, $subname) = explode('.', $name);
        }
        if (!empty($subname)) {
            if (isset($this->posted[$name]) && isset($this->posted[$name][$subname]) && !empty($this->posted[$name][$subname])) {
                return $this->posted[$name][$subname];
            }
            if (empty($default) && isset($this->fields[$name]) && isset($this->fields[$name]['fields'][$subname]) && isset($this->fields[$name]['fields'][$subname]['default'])) {
                return $this->fields[$name]['fields'][$subname]['default'];            
            }
        } else {
            if (isset($this->posted[$name]) && !empty($this->posted[$name])) {
                return $this->posted[$name];
            }
            if (empty($default) && isset($this->fields[$name]) && isset($this->fields[$name]['default'])) {
                return $this->fields[$name]['default'];            
            }
        }
        return $default;
    }

    public function treat(&$email = array())
    {
        if (empty($this->posted)) return null;
        $ok_email = false;

        // MimeEmail object
        $sender = \MimeMailer\Mailer::getInstance();
        
        // from
        $posted_sender = $this->isPosted('sender');
//var_export($posted_sender);
        if (!empty($posted_sender['email'])) {
            $sender->getMessage()->setFrom(
                $posted_sender['email'],
                !empty($posted_sender['name']) ? $posted_sender['name'] : null
            );
        } else {
            $email[] = 'No sender defined!';
            return false;
        }        
                
        // recipients
        $posted_recips = $this->isPosted('recipients');
//var_export($posted_recips);
        if (!empty($posted_recips['to'])) {
            $sender->getMessage()->setTo($posted_recips['to']);
        } else {
            $email[] = 'No classic recipient defined!';
            return false;
        }        
        if (!empty($posted_recips['cc'])) {
            $sender->getMessage()->setCc($posted_recips['cc']);
        }        
        if (!empty($posted_recips['bcc'])) {
            $sender->getMessage()->setBcc($posted_recips['bcc']);
        }        

        // contents
        $posted_contents = $this->isPosted('contents');
//var_export($posted_contents);
        if (!empty($posted_contents['subject'])) {
            $sender->getMessage()->setSubject($posted_contents['subject']);
        } else {
            $email[] = 'No subject defined!';
            return false;
        }        
        if (!empty($posted_contents['plain_text'])) {
            $sender->getMessage()->setText($posted_contents['plain_text']);
        }        
        if (!empty($posted_contents['html'])) {
            $sender->getMessage()->setHtml($posted_contents['html']);
        }        

        // attachments
        $posted_attachments = $this->isPosted('attachments');
//var_export($posted_attachments);
        if (!empty($posted_attachments['files'])) {
            $sender->getMessage()->setAttachment($posted_attachments['files']);
        }
        
        // options
        $posted_options = $this->isPosted('options');
//var_export($posted_options);
        if (!empty($posted_options['reply'])) {
            $sender->getMessage()->setReplyTo($posted_options['reply']);
        }        
        if (!empty($posted_options['follow'])) {
            $sender->getMessage()->setFollowupTo($posted_options['follow']);
        }        
        if (!empty($posted_options['errors'])) {
            $sender->getMessage()->setErrorsTo($posted_options['errors']);
        }        
        if (!empty($posted_options['notify'])) {
            $sender->getMessage()->setDispositionNotificationTo($posted_options['notify']);
        }        

        // sending / spooling
        $ok_email = $sender->send(1);
        $email = array(
            'errors'=>$sender->getErrors(),
            'infos'=>$sender->getInfos(),
            'message'=>$sender->getMessage()->getMessage()
        );
//        $email = $sender;

        return $ok_email;
    }

}

// Endfile