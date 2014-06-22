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