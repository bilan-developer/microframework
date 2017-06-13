<?php

/**
 * Список доступных роутов.
 */
return function(\FastRoute\RouteCollector $r) {
	$r->addRoute('GET', '/users', function($app){
		return $app->get('view')->view()->make('hello',array('value' => 'Переданные параметры'))->render();
	});    	
};