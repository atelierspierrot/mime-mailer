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
 * @author  Piero Wbmstr <me@e-piwi.fr>
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