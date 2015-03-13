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

namespace MimeMailer;

/**
 * @author  piwi <me@e-piwi.fr>
 */
interface MessageInterface
{

    /**
     * Global setter
     *
     * @param string $name
     * @param mixed $val
     */
    public function set($name, $val);

    /**
     * Global getter
     *
     * @param string $name
     */
    public function get($name);

    /**
     * Global variable clearer
     *
     * @param string $name
     */
    public function clear($name = null);

    /**
     * Get message ID
     *
     * @return string
     */
    public function getId();

    /**
     * Get the full built message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set From field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     * @param bool $reply Set the "reply-to" to the same address ? (default is TRUE)
     */
    public function setFrom($mail = '', $name = null, $reply = true);

    /**
     * Set To field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     */
    public function setTo($mail = '', $name = null);

    /**
     * Set Cc field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     */
    public function setCc($mail = '', $name = null);

    /**
     * Set Bcc field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     */
    public function setBcc($mail = '', $name = null);

    /**
     * Set mail file attachment
     *
     * @param string|array $file The file or files to attach
     * @param bool $clear Clear a set content first ? (default is to append a content)
     */
    public function setAttachment($file = '', $clear = false);

    /**
     * Set mail object
     *
     * @param string $subject The subject content
     * @param bool $clear Clear a set content first ? (default is to append a content)
     */
    public function setSubject($subject = '', $clear = false);

    /**
     * Set plain text version
     *
     * If $text='auto', the text version will be generated from the HTML content
     *
     * @param string $text The plain text content or keyword 'auto' to auto-generate it from the HTML content
     * @param bool $clear Clear a set content first ? (default is to append a content)
     */
    public function setText($text = '', $clear = false);

    /**
     * Set HTML version
     *
     * @param string $html The HTML content
     * @param bool $clear Clear a set content first ? (default is to append a content)
     */
    public function setHtml($html = '', $clear = false);

    /**
     * Set Reply-To header field
     *
     * @param string/array $mail The email address to add, or an array of name=>email pairs
     * @param string/bool $name The name to show for the email address if there is just one
     */
    public function setReplyTo($mail = '', $name = null);

}

// Endfile