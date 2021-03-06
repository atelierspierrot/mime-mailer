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

use \Library\Helper\Directory as DirectoryHelper;
use \Library\Helper\File as FileHelper;

/**
 * @author  piwi <me@e-piwi.fr>
 */
class SpoolManager
    implements SpoolInterface, CacheInterface
{

    /**
     * @var string The directory where to create spooled mails files
     */
    protected $spool_dir;

    /**
     * @var int The number of emails to send from spool for each sending
     */
    protected $spool_limit = 50;

    /**
     * @var \MimeMailer\SpoolingCacheInterface The cache object for emails spooling
     */
    protected $cache;

    /**
     * @var int Index of collection
     */
    protected $position = 0;

    /**
     * @var array Collection
     */
    protected $collection = array();

    /**
     * Construction of a MimeEmail object
     *
     * @param string $spool_dir
     */
    public function __construct($spool_dir = null)
    {
        if (!empty($spool_dir)) {
            $this->setSpoolDirectory($spool_dir);
        }
        $this->rewind();
    }

// -----------------------
// SpoolInterface
// -----------------------

    /**
     * Set the spooled mails directory
     *
     * @param string $dir The directory where to create spooled mails files
     * @return self
     * @throws \Exception if the directory doesn't exist and can't be created
     * @see \Library\Helper\Directory::ensureExists()
     */
    public function setSpoolDirectory($dir)
    {
        if (!DirectoryHelper::ensureExists($dir)) {
            throw new \Exception(
                sprintf('Can not create emails spooling directory "%s"!', $dir)
            );
        }
        $this->spool_dir = $dir;
        return $this;
    }

    /**
     * Get the spooled mails directory
     *
     * @return string
     */
    public function getSpoolDirectory()
    {
        return !empty($this->spool_dir) ? DirectoryHelper::slashDirname($this->spool_dir) : '';
    }

    /**
     * Set the spooled files ordering rule
     *
     * @param string $rule
     */
    public function setOrderBy($rule = 'mdate asc')
    {
    }

    public function addMessageToSpool($id, $contents)
    {
        $content = is_array($contents) ? serialize($contents) : $contents;
        return $this->cacheFile($id, $content, true);
    }

    public function getMessageFromSpool($id)
    {
    }

// -----------------------
// CacheInterface
// -----------------------

    /**
     *
     */
    public function cacheFile($filename, $content, $encode_filename = true)
    {
        if (empty($filename)) {
            $filename = uniqid();
        }
        if (true===$encode_filename) {
            $filename = $this->encodeFilename($filename);
        }
        $_fc = $this->getSpoolDirectory().$filename;
//var_export($_fc);
        $cached = fopen($_fc, "w");
        if ($cached) {
            fwrite($cached, $content);
            fclose($cached);
            return $_fc;
        }
        return false;
    }

    /**
     *
     */
    public function isCachedFile($filename)
    {
        $_fc = $this->getSpoolDirectory().$filename;
        if (file_exists($_fc)) {
            return true;
        }
        $_fce = $this->getSpoolDirectory().$this->encodeFilename($filename);
        if (file_exists($_fce)) {
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function getCachedFile($filename)
    {
        $_fc = $this->getSpoolDirectory().$filename;
        if (file_exists($_fc)) {
            return file_get_contents($_fc);
        }
        $_fce = $this->getSpoolDirectory().$this->encodeFilename($filename);
        if (file_exists($_fce)) {
            return file_get_contents($_fce);
        }
        return null;
    }

    /**
     *
     */
    public function encodeFilename($filename)
    {
        return md5($filename);
    }

// -----------------------
// Iterator
// -----------------------

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->collection[$this->position]);
    }
}

// Endfile
