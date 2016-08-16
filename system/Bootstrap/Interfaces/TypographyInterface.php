<?php
/**
 * O2Bootstrap
 *
 * An open source bootstrap components factory for PHP 5.4+
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015, PT. Lingkar Kreasi (Circle Creative).
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
 * @package     O2Bootstrap
 * @author      Circle Creative Dev Team
 * @copyright   Copyright (c) 2005 - 2015, .
 * @license     http://circle-creative.com/products/o2bootstrap/license.html
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        http://circle-creative.com/products/o2parser.html
 * @filesource
 */
// ------------------------------------------------------------------------

namespace O2System\Bootstrap\Interfaces;

trait TypographyInterface
{
	public function textLowercase()
	{
		$this->addClass( 'text-lowercase' );

		return $this;
	}

	public function textUppercase()
	{
		$this->addClass( 'text-uppercase' );

		return $this;
	}

	public function textSmall()
	{
		$this->addClass( 'text-small' );

		return $this;
	}

	public function textCapitalize()
	{
		$this->addClass( 'text-capitalize' );

		return $this;
	}

	public function textMuted()
	{
		$this->addClass( 'text-muted' );

		return $this;
	}

	public function textPrimary()
	{
		$this->addClass( 'text-primary' );

		return $this;
	}

	public function textSuccess()
	{
		$this->addClass( 'text-success' );

		return $this;
	}

	public function textWarning()
	{
		$this->addClass( 'text-warning' );

		return $this;
	}

	public function textDanger()
	{
		$this->addClass( 'text-danger' );

		return $this;
	}
}