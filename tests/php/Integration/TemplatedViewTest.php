<?php

namespace MWPD\MwpdTheme\Tests\Integration;

use MWPD\MwpdTheme\Infrastructure\View\TemplatedView;
use MWPD\MwpdTheme\Infrastructure\View\TemplatedViewFactory;
use MWPD\MwpdTheme\Tests\ViewHelper;

final class TemplatedViewTest extends TestCase {

	public function test_it_loads_partials_across_overrides(): void {
		$partials = new TemplatedView(
			'partial-a',
			new TemplatedViewFactory( ViewHelper::LOCATIONS ),
			ViewHelper::LOCATIONS
		);

		$this->assertStringStartsWith(
			'partial A from plugin - partial B from parent theme - partial C from child theme - partial D from parent theme - partial E from plugin',
			$partials->render()
		);
	}
}
