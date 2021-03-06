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
use O2System\Libraries\Access\Metadata\Credentials;
use O2System\Core\Model;

/**
 * Login Handler Class
 *
 * @package        O2System
 * @subpackage     libraries/Access/drivers
 * @category       Handler Class
 * @author         Steeven Andrian Salim
 * @link           http://o2system.center/products/o2system-ci3.0.0/user-guide/libraries/access/login.html
 */
class Login extends Handler
{
	/**
	 * Access Instance
	 *
	 * @type Access
	 */
	protected $library;

	/**
	 * Login User
	 *
	 *
	 * @param string $username User Username|Email|MSIDN
	 * @param string $password User Password
	 *
	 * @access  public
	 * @return  bool
	 */
	public function set( $username, $password, $remember = FALSE )
	{
		$remember = empty( $remember ) ? FALSE : TRUE;
		$username = trim( $username );
		$password = trim( $password );

		$user = $this->library->model->getAccount( $username );

		if ( $user instanceof \ArrayObject )
		{
			if ( $user->offsetExists( 'salt' ) )
			{
				$hash_password = $this->library->hashPassword( $password, $user->salt );
			}
			else
			{
				$hash_password = $this->library->hashPassword( $password );
			}

			if ( $user->password === $hash_password )
			{
				$this->library->token->setAccess( $user, $password, $remember );

				return TRUE;
			}
		}

		// Log Attempt Login Access
		$this->setAttempt();

		return FALSE;
	}

	// ------------------------------------------------------------------------

	public function setAttempt( $count = 0 )
	{
		if ( $this->getMaxAttempts() > 0 )
		{
			if ( $attempts = $this->getAttempts() )
			{
				$attempts[ 'count' ] = $count > 0 ? $count : $attempts[ 'count' ]++;
			}
			else
			{
				$attempts = [
					'count' => $count,
					'time'  => now(),
				];
			}

			\O2System::$session->set( '__loginAttempts', $attempts );
		}

		return $this;
	}

	public function getAttempts()
	{
		$attempts = [
			'count' => 0,
			'time'  => now(),
		];

		if ( $this->getMaxAttempts() > 0 )
		{
			if ( \O2System::$session->has( '__loginAttempts' ) === FALSE )
			{
				\O2System::$session->set( '__loginAttempts', $attempts );
			}
			else
			{
				$attempts = \O2System::$session->get( '__loginAttempts' );
			}
		}

		return $attempts;
	}

	// ------------------------------------------------------------------------

	public function getMaxAttempts()
	{
		return (int) $this->_config[ 'attempts' ];
	}

	public function fromCredentials( Credentials $credentials )
	{
		if ( $this->library->getConfig( 'login', 'match_ip' ) === TRUE )
		{
			if ( $credentials[ 'ip_address' ] !== \O2System::$request->getIpAddress() )
			{
				return FALSE;
			}
		}

		if ( $this->library->getConfig( 'login', 'match_agent' ) === TRUE )
		{
			if ( $credentials[ 'user_agent' ] !== \O2System::$request->getUserAgent() )
			{
				return FALSE;
			}
		}

		if ( $this->library->model instanceof Model )
		{
			if ( $user = $this->library->model->getAccount( $credentials[ 'id_user_account' ] ) )
			{
				if ( $user instanceof \ArrayObject === FALSE )
				{
					return FALSE;
				}

				$this->library->token->setAccess( $user, $user->password, (bool) empty( get_cookie( 'remember' ) ) );

				return TRUE;
			}
		}

		return FALSE;
	}
}
