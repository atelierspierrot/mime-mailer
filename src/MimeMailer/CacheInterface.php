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

/**
 * A classic cache interface
 *
 * @author  piwi <me@e-piwi.fr>
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
