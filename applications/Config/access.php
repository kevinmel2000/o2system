<?php
/**
 * O2System
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014, PT. Lingkar Kreasi (Circle Creative)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package        Applications
 * @author         PT. Lingkar Kreasi (Circle Creative)
 * @copyright      Copyright (c) 2005 - 2014, PT. Lingkar Kreasi (Circle Creative)
 * @license        http://www.o2system.io/license.html
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link           http://www.o2system.io
 * @since          Version 2.0
 * @filesource
 */
// ------------------------------------------------------------------------

defined( 'ROOTPATH' ) OR exit( 'No direct script access allowed' );

// ------------------------------------------------------------------------

$access[ 'login' ][ 'attempts' ]    = 5;
$access[ 'login' ][ 'match_ip' ]    = FALSE;
$access[ 'login' ][ 'match_agent' ] = TRUE;

$access[ 'password' ][ 'hash' ]   = 'MD5';
$access[ 'password' ][ 'salt' ]   = FALSE;
$access[ 'password' ][ 'rehash' ] = FALSE;

$access[ 'register' ][ 'from_email' ] = 'no-reply@o2system.io';
$access[ 'register' ][ 'from_name' ]  = 'O2System PHP Framework';
$access[ 'register' ][ 'subject' ]    = 'O2System Registration';

$access[ 'remember' ][ 'access' ]   = TRUE;
$access[ 'remember' ][ 'lifetime' ] = 259200;

$access[ 'sso' ][ 'access' ]   = TRUE;
$access[ 'sso' ][ 'lifetime' ] = 259200;

$access[ 'token' ][ 'access' ]   = TRUE;
$access[ 'token' ][ 'lifetime' ] = 259200;