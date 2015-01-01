<?php
/**
 * MimeMailer - PHP package to send rich MIME emails
 * Copyleft (ↄ) 2013-2015 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/mime-mailer>
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
 */

namespace MimeMailer\Transport;

use \MimeMailer\Mailer;
use \MimeMailer\TransportInterface;

/*
PHP Mail function :
bool mail ( string $to , string $subject , string $message [, string $additional_headers [, string $additional_parameters ]] )
*/

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
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
     * @param   string $to
     * @param   string $subject
     * @param   string $message
     * @param   string $additional_headers
     * @param   string $additional_parameters
     * @return  mixed
     * @see     mail()
     */
    public function transport($to, $subject, $message, $additional_headers = '', $additional_parameters = '')
    {
        return mail($to, $subject, $message, $additional_headers, $additional_parameters);
    }

}

// Endfile