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