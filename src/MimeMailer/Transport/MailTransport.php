<?php
/**
 * MimeMailer - PHP package to send rich MIME emails
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/mime-mailer>
 */

namespace MimeMailer\Transport;

use \MimeMailer\Mailer;
use \MimeMailer\TransportInterface;

/*
PHP Mail function :
bool mail ( string $to , string $subject , string $message [, string $additional_headers [, string $additional_parameters ]] )
*/

/**
 */
class MailTransport
    implements TransportInterface
{

    /**
     * Define the `sendmail` path if so
     */
    public function __construct()
    {
        $sendmail_path = Mailer::getInstance()->getOption('sendmail_path');
		if (!empty($sendmail_path)) {
			@ini_set('sendmail_path', $sendmail_path);
		}
    }

	/**
	 * Validate this transport way
	 *
	 * @return bool Must return a boolean after testing the transport way in current envionement
	 */
	public function validate()
	{
	    return true;
	}

	/**
	 * Messages sender : prepare the whole content and send the e-mail
	 *
	 * @param string $to
	 * @param string $subject
	 * @param string $message
	 * @param string $additional_headers
	 * @param string $additional_parameters
	 *
	 * @return misc
	 *
	 * @see mail()
	 */
	public function transport($to, $subject, $message, $additional_headers = '', $additional_parameters = '')
	{
		return mail($to, $subject, $message, $additional_headers, $additional_parameters);
	}

}

// Endfile