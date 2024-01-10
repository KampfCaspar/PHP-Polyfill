<?php declare(strict_types=1);
/**
 * This program is free software: you can redistribute it and/or modify it under the terms of the
 * GNU Affero General Public License as published by the Free Software Foundation, either version 3
 * of the License, or (at your option) any later version.
 *
 * @license AGPL-3.0-or-later
 * @author KampfCaspar <code@kampfcaspar.ch>
 */

namespace KampfCaspar\Polyfill;

final class Types
{
	/**
	 * get a meaningful type string from parameter
	 *
	 * Variable types include 'object' and 'resource' that are not really
	 * useful by themselves. Rather return the object's class name, describe the resource
	 * type in these cases.
	 */
	public static function getType(mixed $subject): string
	{
		return is_object($subject)
			? get_class($subject)
			: (is_resource($subject)
				? get_resource_type($subject)
				: gettype($subject)
			);
	}

	/**
	 * deep clone an array but not objects
	 *
	 * Arrays are supposed to be assigned by value in PHP - but that's only true for flat arrays.
	 * Nested arrays are treated like objects and added to the new array by reference.   :-O
	 * This polyfill closes that gap, deep copying arrays but not objects.
	 */
	public static function cloneArray(array $subject): array
	{
		return array_map(function($x) {
			return ((is_array($x))
				? self::cloneArray($x)
				: $x
			);
		}, $subject);
	}

}