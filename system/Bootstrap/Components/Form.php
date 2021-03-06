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
namespace O2System\Bootstrap\Components;


use O2System\Bootstrap\Interfaces\FactoryInterface;

class Form extends FactoryInterface
{
	const DEFAULT_FORM    = 'FORM_GROUP';
	const VERTICAL_FORM   = 'FORM_GROUP_VERTICAL';
	const HORIZONTAL_FORM = 'FORM_GROUP_HORIZONTAL';
	const INLINE_FORM     = 'FORM_GROUP_INLINE';

	const INSERT_FORM = 'FORM_INSERT';
	const UPDATE_FORM = 'FORM_UPDATE';

	protected $_tag        = 'form';
	protected $_attributes = [
		'role' => 'form',
	];

	protected $_type   = 'FORM_INSERT';
	protected $_layout = 'standard';

	public $fieldsets = [
		'main'    => [ ],
		'buttons' => [ ],
	];

	/**
	 * build
	 *
	 * @return type
	 */
	public function build()
	{
		@list( $type, $attr ) = func_get_args();

		if ( is_string( $type ) )
		{
			$this->addClass( 'form-' . $type );
		}
		elseif ( is_array( $type ) )
		{
			$attr = $type;
		}

		if ( isset( $attr ) )
		{
			$this->addAttributes( $attr );
		}

		return $this;

	}

	// ------------------------------------------------------------------------


	public function addGroup( $group )
	{
		if ( ! in_array( $group, array_keys( $this->fieldsets ) ) )
		{
			$this->fieldsets[ $group ] = [ ];
		}
	}

	public function setType( $type )
	{
		$this->_type = $type;
	}

	public function setAttributes( array $attr )
	{
		if ( empty( $attr[ 'id' ] ) )
		{
			$attr[ 'id' ] = implode( '-', \O2System::$request->uri->segments ) . '-form';
		}

		$this->addAttributes( $attr );

		return $this;
	}

	public function setLayout( $layout )
	{
		$this->_layout = $layout;

		switch ( $layout )
		{
			case 'columns':

				$this->addGroup( 'sidebar' );

				break;

			default:
			case 'standard':
				# code...
				break;
		}

		return $this;
	}

	public function setFieldsets( array $fieldsets, $group = 'main' )
	{
		if ( array_key_exists( $group, $this->_fieldsets ) )
		{
			foreach ( $fieldsets as $legend => $fieldset )
			{
				$this->setFieldset( $fieldset, $legend, $group );
			}
		}
	}

	public function setFieldset( array $fieldset, $legend = '', $group = 'main' )
	{
		if ( array_key_exists( $group, $this->_fieldsets ) )
		{
			$this->fieldsets[ $group ][ $legend ] = $fieldset;
		}
	}

	public function setButtons( array $buttons )
	{
		$this->_custom_buttons = $buttons;
	}

	public function render()
	{
		// Collect Fieldsets
		$fieldsets = new Fieldset( $this->fieldsets );

		// Collect Buttons
		switch ( $this->_type )
		{
			case 'FORM_UPDATE':

				$buttons = new Button( $this->_update_buttons );

				break;

			default:

				$buttons = new Button( $this->_insert_buttons );

				break;
		}

		if ( ! empty( $this->_custom_buttons ) )
		{
			$buttons = new Button( $this->_custom_buttons );
		}

		$form = new Tag( 'form', $this->_config[ 'attr' ] );

		foreach ( $this->_library->_paths as $path )
		{
			if ( is_dir( $layout_path = $path . 'views' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR ) )
			{
				foreach ( $this->_library->parser->extensions as $extension )
				{
					if ( is_file( $filepath = $layout_path . $this->_config[ 'layout' ] . $extension ) )
					{
						$content = $this->_library->parser->parseFile( $filepath, [ 'fieldsets' => $fieldsets, 'buttons' => $buttons ], TRUE );
						$form->setContent( $content );
					}
				}
			}
		}

		return $form->render();
	}

	public function __toString()
	{
		return $this->render();
	}
}
