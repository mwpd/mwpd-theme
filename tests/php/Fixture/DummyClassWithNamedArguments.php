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

namespace MWPD\MwpdTheme\Tests\Fixture;

final class DummyClassWithNamedArguments {

	/** @var int */
	private $argument_a;

	/** @var string */
	private $argument_b;

	public function __construct( int $argument_a, string $argument_b = 'Mr Meeseeks' ) {
		$this->argument_a = $argument_a;
		$this->argument_b = $argument_b;
	}

	public function get_argument_a(): int {
		return $this->argument_a;
	}

	public function get_argument_b(): string {
		return $this->argument_b;
	}
}
