<?php
/**
 * MimeMailer - PHP package to send rich MIME emails
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/mime-mailer>
 */

namespace MimeMailer;

/**
 * The classic cache interface
 *
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
interface CacheInterface
{

	public function cacheFile($filename, $content, $encode_filename = true);

	public function isCachedFile($filename);

	public function getCachedFile($filename);

}

// Endfile