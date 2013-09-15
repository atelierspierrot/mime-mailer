<?php
/**
 * MimeEmail - PHP package to send full emails
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/mime-email>
 */

namespace MimeEmail;

/**
 * The spooling management class
 *
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
abstract class AbstractMailerAware
{

	/**
	 * Get the mailer instance
	 *
	 * @return \MimeEmail\Mailer
	 */
    public function getMailer()
    {
        return Mailer::getInstance();
    }

}

// Endfile