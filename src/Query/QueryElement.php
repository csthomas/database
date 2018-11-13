<?php
/**
 * Part of the Joomla Framework Database Package
 *
 * @copyright  Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Database\Query;

/**
 * Query Element Class.
 *
 * @property-read  string  $name      The name of the element.
 * @property-read  array   $elements  An array of elements.
 * @property-read  string  $glue      Glue piece.
 *
 * @since  1.0
 */
class QueryElement
{
	/**
	 * The name of the element.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $name;

	/**
	 * An array of elements.
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $elements = [];

	/**
	 * Glue piece.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $glue;

	/**
	 * Constructor.
	 *
	 * @param   string  $name      The name of the element.
	 * @param   mixed   $elements  String or array.
	 * @param   string  $glue      The glue for elements.
	 *
	 * @since   1.0
	 */
	public function __construct($name, $elements, $glue = ',')
	{
		$this->name = $name;
		$this->glue = $glue;

		$this->append($elements);
	}

	/**
	 * Magic function to convert the query element to a string.
	 *
	 * @return  string
	 *
	 * @since   1.0
	 */
	public function __toString()
	{
		if (substr($this->name, -2) === '()')
		{
			return PHP_EOL . substr($this->name, 0, -2) . '(' . implode($this->glue, $this->elements) . ')';
		}

		return PHP_EOL . $this->name . ' ' . implode($this->glue, $this->elements);
	}

	/**
	 * Appends element parts to the internal list.
	 *
	 * @param   mixed  $elements  String or array.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function append($elements)
	{
		if (\is_array($elements))
		{
			$this->elements = array_merge($this->elements, $elements);
		}
		else
		{
			$this->elements = array_merge($this->elements, [$elements]);
		}
	}

	/**
	 * Gets the elements of this element.
	 *
	 * @return  array
	 *
	 * @since   1.0
	 */
	public function getElements()
	{
		return $this->elements;
	}

	/**
	 * Gets the name of this element.
	 *
	 * @return  string  Name of the element.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets the name of this element.
	 *
	 * @param   string  $name  Name of the element.
	 *
	 * @return  $this
	 *
	 * @since   1.3.0
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Method to provide deep copy support to nested objects and arrays when cloning.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function __clone()
	{
		foreach ($this as $k => $v)
		{
			if (\is_object($v) || \is_array($v))
			{
				$this->{$k} = unserialize(serialize($v));
			}
		}
	}
}
