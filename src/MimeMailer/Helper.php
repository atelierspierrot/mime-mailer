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

use \Patterns\Abstracts\AbstractSingleton;
use \Patterns\Interfaces\OptionableInterface;
use \Library\Converter\Html2Text;
use \Library\Helper\Directory as DirectoryHelper;
use \Validator\EmailValidator;

/**
 * @author  piwi <me@e-piwi.fr>
 */
class Helper
{

// --------------------
// RFC 2822 builder
// --------------------

    /**
     * Build a person string compliant to RFC2822
     *
     * @param string $mail The person's email address
     * @param string $name The person's name if so
     * @return string The generated tag
     */
    public static function mailTagger($mail = '', $name = null)
    {
        return( (!is_int($name) ? "\"".$name."\" <" : '').$mail.(!is_int($name) ? ">" : '') );
    }

    /**
     * Build a list of person strings compliant to RFC2822
     *
     * @param string|array $list
     * @return string
     */
    public static function mailListTagger(array $list)
    {
        $str = '';
        foreach ($list as $name=>$mail) {
            if (is_string($mail)) {
                $str .= self::mailTagger($mail,$name).Mailer::$ADDERSSES_SEPARATOR;
            } elseif (is_array($mail)) {
                foreach ($mail as $subname=>$submail) {
                    $str .= self::mailTagger($submail,$subname).Mailer::$ADDERSSES_SEPARATOR;
                }
            }
        }
        return $str;
    }

    /**
     * Build a mail header tag compliant to RFC2822
     *
     * @param string $name The name of the tag
     * @param string $value The value of the tag
     * @param array $adds A variable=>value pairs to add to the tag string
     * @return string The generated header tag string
     */
    public static function headerTagger($name = '', $value = '', $adds = array())
    {
        $str = $name.': '.$value;
        if (count($adds)) {
            foreach($adds as $n=>$v) {
                $str .= Mailer::$HEADERS_SEPARATOR.($n=='boundary' ? "\n\t" : '').$n."=\"".$v."\"";
            }
        }
        return(trim($str, Mailer::$HEADERS_SEPARATOR));
    }

    /**
     * Build a list of name=>email pairs compliant to RFC2822
     *
     * @param array $list A list of name=>email pairs
     * @param string $type The type of the field
     * @return string The generated list
     */
    public static function listAddresses($list = array(), $type = 'to')
    {
        if (empty($list)) return;
        $str = ucfirst(strtolower($type)).': '.self::mailListTagger($list);
        return(trim($str, Mailer::$ADDERSSES_SEPARATOR).Mailer::$LINE_ENDING);
    }

// --------------------
// Utilities
// --------------------

    /**
     * Format a text with a special encoding
     *
     * @param string $txt The text to format
     * @param string $type The type of the encoding : 'plain' or 'ascii'
     * @param bool $spaces Replace all spaces with underscores or not (default is FALSE)
     * @return string The transformed text
     */
    public static function formatText($txt = '', $type = 'plain', $spaces = false)
    {
        switch($type) {
            case 'ascii' :
                $_txt = '';
                if ($spaces==true) $txt = str_replace(' ', '_', $txt);
                for($i=0; $i<strlen($txt);$i++) $_txt .= self::charAscii($txt[$i]);
                $txt = $_txt;
                break;
            default : break;
        }

        $mailer = Mailer::getInstance();
        $limit = $mailer->getOption('wordwrap_limit');
        $formated='';
        foreach (explode("\n", $txt) as $_line) {
            $_line = trim($_line);
            if (strlen($_line)>$limit) {
                $_line = wordwrap($_line, $limit, Mailer::$LINE_ENDING);
            }
            if (strlen($_line)) $formated .= $_line.Mailer::$LINE_ENDING;
        }
        return $formated;
    }

    /**
     * Search the MIME type of a file
     *
     * @param string $filename The filename to check
     * @return string The associated MIME type
     */
    public static function getMimeType($filename = '')
    {
        $ext = strtolower(substr($filename, strrpos($filename, '.')));
        switch ($ext) {
            case '.jpeg': case '.jpg': $mimetype = 'image/jpeg'; break;
            case '.gif': $mimetype = 'image/gif'; break;
            case '.png': $mimetype = 'image/png'; break;
            case '.txt': $mimetype = 'text/plain'; break;
            case '.html': case '.htm': $mimetype = 'text/html'; break;
            case '.zip': $mimetype = 'application/x-zip-compressed'; break;
            default: $mimetype = 'application/octet-stream';
        }
        return $mimetype;
    }

    /**
     * Converts HTML to plain text
     *
     * @param string $str The HTML content to transform
     * @return string The associated plain text version
     */
    public static function html2text($str)
    {
        return Html2Text::convert($str);
    }

    /**
     * De-duplicate a set of name=>email pairs to let each email just once
     *
     * @param array $array
     * @return array
     */
    public static function deduplicate($array)
    {
        if (empty($array)) return $array;
        $known = array();
        foreach ($array as $_index=>$entry) {
            if (is_array($entry)) {
                foreach ($entry as $i=>$_email) {
                    if (!in_array($_email, $known)) {
                        $known[] = $_email;
                    } else {
                        unset($array[$_index]);
                    }
                }
            } elseif (is_string($entry)) {
                if (!in_array($entry, $known)) {
                    $known[] = $entry;
                } else {
                    unset($array[$_index]);
                }
            }
        }
        return $array;
    }

    /**
     * Clean and build a set of name=>email pairs
     *
     * Arguments can be writtent as :
     * ( 'my@email.address' )
     * ( 'my@email.address', 'my name' )
     * ( array( 'my name'=>'my@email.address' ) )
     * ( array( 'my name'=>'my@email.address', 'another name'=>'another@email.address' ) )
     * ( array( 'my name'=>'my@email.address', 'another@email.address' ) )
     *
     * @return array
     */
    public static function checkPeopleArgs()
    {
        $args = func_get_args();
        if (empty($args)) return array();

        // 1 only email
        if (count($args)==1 && is_string($args[0]) && self::isEmail($args[0])) {
            return array( array($args[0]) );
        }

        // 2 args and 2nd is not an email
        if (
            count($args)==2 &&
            (isset($args[0]) && true===self::isEmail($args[0])) &&
            (isset($args[1]) && false===self::isEmail($args[1]))
        ) {
            return array( array( $args[1]=>$args[0] ) );
        }

        // a set of name=>email pairs
        if (count($args)==1) $args = $args[0];
        $result=array();
        foreach($args as $name=>$email) {
            if (is_string($name) && true===self::isEmail($email)) {
                $result[] = array( $name=>$email );
            } elseif (is_numeric($name) && true===self::isEmail($email)) {
                $result[] = array($email);
            }
        }
        return $result;
    }

    /**
     * Returns the ASCII equivalent of a character
     *
     * @param string $char The character to test
     * @return string The ASCII valid character
     */
    public static function charAscii($char)
    {
        if (self::isAscii($char)) return $char;
        $char = htmlentities($char);
        return $char;
    }

    /**
     * ASCII validator
     *
     * @param string $string The content to test
     * @return bool
     */
    public static function isAscii($string)
    {
        return !strlen(preg_replace(',[\x09\x0A\x0D\x20-\x7E],sS','', $string));
    }

    /**
     * Check if an email address is valid
     *
     * @param string $str The email address to check
     * @return bool
     */
    public static function isEmail($str = '')
    {
        $v = new EmailValidator;
        return $v->validate($str);
    }

}

// Endfile