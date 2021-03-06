<?php
/**
 * O2System
 *
 * An open source application development framework for PHP 5.4+
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015, .
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
 * @package        O2System
 * @author         Circle Creative Dev Team
 * @copyright      Copyright (c) 2005 - 2015, .
 * @license        http://circle-creative.com/products/o2system-codeigniter/license.html
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link           http://circle-creative.com/products/o2system-codeigniter.html
 * @since          Version 2.0
 * @filesource
 */
// ------------------------------------------------------------------------

namespace O2System\Libraries\Access\Handlers;
defined( 'ROOTPATH' ) OR exit( 'No direct script access allowed' );

// ------------------------------------------------------------------------

use O2System\Core\Library\Handler;
use O2System\Core\SPL\ArrayObject;
use O2System\Libraries\Access;

/**
 * User Handler Class
 *
 * @package        O2System
 * @subpackage     libraries/Access/drivers
 * @category       Handler Class
 * @author         Steeven Andrian Salim
 * @link           http://o2system.center/products/o2system-ci3.0.0/user-guide/libraries/access/login.html
 */
class User extends Handler
{
	/**
	 * Access Instance
	 *
	 * @type Access
	 */
	protected $library;

	/**
	 * User Account
	 *
	 * @param string $return
	 *
	 * @return array|null|object
	 */
	public function account( $return = NULL )
	{
		if ( $this->isLogin() )
		{
			if ( $account = \O2System::$session->get( 'account' ) )
			{
				if ( $account instanceof \ArrayObject )
				{
					if ( isset( $return ) )
					{
						if ( $account->offsetExists( $return ) )
						{
							return $account->offsetGet( $return );
						}
					}

					return $account;
				}
			}
		}

		\O2System::$session->remove( 'account' );

		return NULL;
	}

	// ------------------------------------------------------------------------

	/**
	 * Is Login
	 *
	 * Check if user is already login
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isLogin()
	{
		if ( \O2System::$session->has( 'account' ) )
		{
			$account = \O2System::$session->get( 'account' );

			if ( $account instanceof ArrayObject )
			{
				if ( $account->isEmpty() === FALSE )
				{
					\O2System::$active[ 'account' ] = $account;

					return TRUE;
				}
			}

			\O2System::$session->remove( 'account' );

			return $this->isLogin();
		}
		elseif ( \O2System::$request->useragent->isBrowser() )
		{
			if ( $credentials = $this->library->cookie->getRemember() )
			{
				return $this->library->login->fromCredentials( $credentials );
			}
			elseif ( $credentials = $this->library->cookie->getSso() )
			{
				return $this->library->login->fromCredentials( $credentials );
			}
		}

		if ( $xWebToken = \O2System::$request->getHeader( 'X_WEB_TOKEN' ) )
		{
			list( $token ) = sscanf( $xWebToken, 'WT-%s' );

			if ( isset( $token ) )
			{
				if ( $credentials = $this->library->token->getCredentials( $token ) )
				{
					return $this->library->login->fromCredentials( $credentials );
				}
			}
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Logout
	 *
	 * Destroy session, cookie, sso for active user
	 *
	 * @access  public
	 */
	public function destroy()
	{
		foreach ( [ 'remember', 'sso' ] as $cookie_name )
		{
			if ( $credentials = $this->library->cookie->{'get' . ucfirst( $cookie_name )}() )
			{
				if ( $cache = \O2System::$cache->get( $cookie_name . '-' . $credentials[ 'signature' ] ) )
				{
					\O2System::$cache->delete( $cookie_name . '-' . $credentials[ 'signature' ] );
				}
			}
		}

		if ( $cache = \O2System::$cache->get( 'token-' . $credentials[ 'signature' ] ) )
		{
			\O2System::$cache->delete( 'token-' . $credentials[ 'signature' ] );
		}

		$this->library->cookie->destroy();
		\O2System::$session->destroy();
	}
}
