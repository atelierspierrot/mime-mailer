<?php
/**
 * This file is part of the MimeMailer package.
 *
 * Copyright (c) 2013-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/mime-mailer>.
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