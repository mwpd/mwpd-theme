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

namespace MWPD\MwpdTheme;

use MWPD\MwpdTheme\Asset\MainStylesheet;
use MWPD\MwpdTheme\Infrastructure\{
	ServiceBasedTheme,
	View\TemplatedViewFactory,
	ViewFactory
};

/**
 * The MwpdTheme class is the composition root of the theme.
 *
 * In here we assemble our infrastructure, configure it for the specific use
 * case the theme is meant to solve and then kick off the services so that they
 * can hook themselves into the WordPress lifecycle.
 */
final class MwpdTheme extends ServiceBasedTheme {

	/*--------------------------------------------------------------------------
	 *-- 1. Define the services that make up this theme.                     --
	 *------------------------------------------------------------------------*/

	/*
	 * The "theme" is only a tool to hook arbitrary code up to the WordPress
	 * execution flow.
	 *
	 * The main structure we use to modularize our code is "services". These are
	 * what makes up the actual theme, and they provide self-contained pieces
	 * of code that can work independently.
	 */

	/**
	 * Get the list of services to register.
	 *
	 * The services array contains a map of <identifier> => <service class name>
	 * associations.
	 *
	 * @return array<string> Associative array of identifiers mapped to fully
	 *                       qualified class names.
	 */
	protected function get_service_classes(): array {
		return [
			// Add your service definitions here.
			self::MAIN_STYLESHEET_ID => MainStylesheet::class,
			self::VIEW_FACTORY_ID    => ViewFactory::class,
		];
	}

	/*--------------------------------------------------------------------------
	 *-- 2. Configure the injector so it knows how to assemble them.          --
	 *------------------------------------------------------------------------*/

	/**
	 * Get the bindings for the dependency injector.
	 *
	 * The bindings array contains a map of <interface> => <implementation>
	 * mappings, both of which should be fully qualified class names (FQCNs).
	 *
	 * The <interface> does not need to be the actual PHP `interface` language
	 * construct, it can be a `class` as well.
	 *
	 * Whenever you ask the injector to "make()" an <interface>, it will resolve
	 * these mappings and return an instance of the final <class> it found.
	 *
	 * @return array<string> Associative array of fully qualified class names.
	 */
	protected function get_bindings(): array {
		return [
			// Map the ViewFactory interface to a concrete implementation.
			ViewFactory::class => TemplatedViewFactory::class,

			// Add your bindings here.
		];
	}

	/**
	 * Get the argument bindings for the dependency injector.
	 *
	 * The arguments array contains a map of <class> => <associative array of
	 * arguments> mappings.
	 *
	 * The array is provided in the form <argument name> => <argument value>.
	 *
	 * @return array<array> Associative array of arrays mapping argument names
	 *                      to argument values.
	 */
	protected function get_arguments(): array {
		return [
			// Example - add a scalar value to an argument for SampleService:
			// SampleService::class => [ 'argument_name' => 'value' ],

			// Add your argument mappings here.
		];
	}

	/**
	 * Get the shared instances for the dependency injector.
	 *
	 * The shared instances array contains a list of FQCNs that are meant to be
	 * reused. For multiple "make()" requests, the injector will return the same
	 * instance reference for these, instead of always returning a new one.
	 *
	 * This effectively turns these FQCNs into a "singleton", without incurring
	 * all the drawbacks of the Singleton design anti-pattern.
	 *
	 * @return array<string> Array of fully qualified class names.
	 */
	protected function get_shared_instances(): array {
		return [
			// Example - make SampleService be shared amongst instantiations:
			// SampleService::class

			// Add your shared instances here.
		];
	}

	/**
	 * Get the delegations for the dependency injector.
	 *
	 * The delegations array contains a map of <class> => <callable>
	 * mappings.
	 *
	 * The <callable> is basically a factory to provide custom instantiation
	 * logic for the given <class>.
	 *
	 * @return array<callable> Associative array of callables.
	 */
	protected function get_delegations(): array {
		return [
			// Add a factory for instantiating WP_Post objects:
			\WP_Post::class => static function () { return \get_post( \get_the_ID() ); }

			// Add your delegations here.
		];
	}

	/*--------------------------------------------------------------------------
	 *-- 3. Define prefixes and identifiers for outside access.               --
	 *------------------------------------------------------------------------*/

	/*
	 * Prefixes to use.
	 *
	 * These are provided so that if multiple themes or plugins use the same boilerplate
	 * code, there hooks and service identifiers are scoped and don't clash.
	 */
	protected const HOOK_PREFIX    = 'mwpd.mwpd-theme.';
	protected const SERVICE_PREFIX = 'mwpd.mwpd-theme.';

	/*
	 * Service identifiers we know about.
	 *
	 * These can be used from outside code as well to directly refer to a
	 * service when talking to the service container.
	 */
	public const MAIN_STYLESHEET_ID = self::SERVICE_PREFIX . 'main-stylesheet';
	public const VIEW_FACTORY_ID    = self::SERVICE_PREFIX . 'view-factory';
}
