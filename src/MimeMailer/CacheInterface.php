<?php
/**
 * MimeMailer - PHP package to send rich MIME emails
 * Copyleft (c) 2013-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/mime-mailer>
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