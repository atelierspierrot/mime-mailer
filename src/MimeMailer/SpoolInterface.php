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
 * The spooling management class
 *
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
interface SpoolInterface extends \Iterator
{

    /**
     * Set the spooled mails directory
     *
     * @param string $dir
     */
    public function setSpoolDirectory($dir);

    /**
     * Set the spooled files ordering rule
     *
     * @param string $rule
     */
    public function setOrderBy($rule = 'mdate asc');

    /**
     * Add a message to spool mails
     *
     * @param string $id
     * @param string|array $contents
     */
    public function addMessageToSpool($id, $contents);

    /**
     * Get a message from spool mails by ID
     *
     * @param string $id
     */
    public function getMessageFromSpool($id);

}

// Endfile