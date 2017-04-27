<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('<presenter>[/<action>]', [
			'presenter' => [
				Route::VALUE => 'Homepage',
				Route::FILTER_TABLE => [
					'uvod' => 'Homepage',
					'omne' => 'About',
					'galerie' => 'Gallery',
					'cenik' => 'Pricelist',
					'kontakt' => 'Contact'
				],
			],
			'action' => [
				Route::VALUE => 'default',
				Route::FILTER_TABLE => [

				]
			]
		]);
		return $router;
	}

}
