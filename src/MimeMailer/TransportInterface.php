<?php
/**
 * This file is part of the MimeMailer package.
 *
 * Copyright (c) 2013-2016 Pierre Cassat <me@e-piwi.fr> and contributors
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
interface TransportInterface
{

    /**
     * Validate this transport way
     *
     * @return bool Must return a boolean after testing the transport way in current envionement
     */
    public function validate();

    /**
     * Real transport
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $additional_headers
     * @param string $additional_parameters
     */
    public function transport($to, $subject, $message, $additional_headers = '', $additional_parameters = '');
}

// Endfile
