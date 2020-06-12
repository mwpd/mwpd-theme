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

namespace MWPD\MwpdTheme\Infrastructure\ServiceContainer;

use MWPD\MwpdTheme\Exception\InvalidService;
use MWPD\MwpdTheme\Infrastructure\Service;
use MWPD\MwpdTheme\Infrastructure\ServiceContainer;
use ArrayObject;

/**
 * A simplified implementation of a service container.
 *
 * We extend ArrayObject so we have default implementations for iterators and
 * array access.
 */
final class SimpleServiceContainer
	extends ArrayObject
	implements ServiceContainer {

	/**
	 * Find a service of the container by its identifier and return it.
	 *
	 * @param string $id Identifier of the service to look for.
	 *
	 * @throws InvalidService If the service could not be found.
	 *
	 * @return Service Service that was requested.
	 */
	public function get( string $id ): Service {
		if ( ! $this->has( $id ) ) {
			throw InvalidService::from_service_id( $id );
		}

		$service = $this->offsetGet( $id );

		// Instantiate actual services if they were stored lazily.
		if ( $service instanceof LazilyInstantiatedService ) {
			$service = $service->instantiate();
			$this->put( $id, $service );
		}

		return $service;
	}

	/**
	 * Check whether the container can return a service for the given
	 * identifier.
	 *
	 * @param string $id Identifier of the service to look for.
	 *
	 * @return bool
	 */
	public function has( string $id ): bool {
		return $this->offsetExists( $id );
	}

	/**
	 * Put a service into the container for later retrieval.
	 *
	 * @param string  $id      Identifier of the service to put into the
	 *                         container.
	 * @param Service $service Service to put into the container.
	 */
	public function put( string $id, Service $service ): void {
		$this->offsetSet( $id, $service );
	}
}
