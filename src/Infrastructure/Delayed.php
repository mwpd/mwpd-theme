<?php declare( strict_types=1 );

/**
 * Modern\WP::development() Homepage Theme.
 *
 * @package   MWPD\MwpdTheme
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      https://www.modernwp.dev/
 * @copyright 2019 Alain Schlesser
 */

namespace MWPD\MwpdTheme\Infrastructure;

/**
 * Something that is delayed to a later point in the execution flow.
 *
 * A class marked as being delayed can return the action at which it requires
 * to be registered.
 *
 * This can be used to only register a given object after certain contextual
 * requirements are met, like registering a frontend rendering service only
 * after the loop has been set up.
 */
interface Delayed {

	/**
	 * Get the action to use for registering the service.
	 *
	 * @return string Registration action to use.
	 */
	public static function get_registration_action(): string;
}
