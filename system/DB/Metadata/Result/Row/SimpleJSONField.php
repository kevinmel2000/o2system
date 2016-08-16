<?php
/**
 * Created by PhpStorm.
 * User: steevenz
 * Date: 26-Jul-16
 * Time: 7:53 AM
 */

namespace O2System\DB\Metadata\Result\Row;

use O2System\Core\SPL\ArrayObject;

class SimpleJSONField extends ArrayObject
{
	public function __construct( $data = [ ] )
	{
		parent::__construct( [ ] );

		if ( ! empty( $data ) )
		{
			foreach ( $data as $key => $value )
			{
				$this->__set( $key, $value );
			}
		}
	}

	public function __set( $index, $value )
	{
		if ( is_array( $value ) )
		{
			$value = new SimpleJSONField( $value );
		}

		$this->offsetSet( $index, $value );
	}

	public function __toArray()
	{
		return $this->getArrayCopy();
	}
}