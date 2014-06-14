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
 * Extend an object to be `\MimeMailer\Mailer` aware
 *
 * @author 		Piero Wbmstr <me@e-piwi.fr>
 */
abstract class AbstractMailerAware
{

	/**
	 * Get the mailer instance
	 *
	 * @return \MimeMailer\Mailer
	 */
    public function getMailer()
    {
        return Mailer::getInstance();
    }

}

// Endfile