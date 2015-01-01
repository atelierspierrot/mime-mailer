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

namespace MimeMailer;

/**
 * A classic cache interface
 *
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
interface CacheInterface
{

    /**
     * Must create a new version of a file in cache
     *
     * @param   string $filename
     * @param   string $content
     * @param   bool $encode_filename
     * @return  bool
     */
    public function cacheFile($filename, $content, $encode_filename = true);

    /**
     * Test if a version of a file exists in cache
     *
     * @param   string $filename
     * @return  bool
     */
    public function isCachedFile($filename);

    /**
     * Get the cached version of a file
     *
     * @param   string $filename
     * @return  string
     */
    public function getCachedFile($filename);

}

// Endfile