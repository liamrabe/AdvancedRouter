<?php
namespace LiamRabe\AdvancedRouter\Interface;

use Closure;
use LiamRabe\AdvancedRouter\Collection\Collection;

interface IRoute {

	public function __construct(
		string $method,
		string $uri,
		Closure|array $callback,
		array $middleware
	);

	public function getURI(): string;

	public function getMethod(): string;

	public function getCallback(): string|array|Callable;

	/**
	 * @return object[]
	 */
	public function getMiddleware(): array;

	/**
	 * Return an instance of Parameters with data from the URL, ex GET-parameters should be returned from here
	 *
	 * @see Route::getParameters
	 */
	public function getParameters(string $uri): Collection;

	/**
	 * Check if current route is a match to the current request uri
	 */
	public function match(string $uri): bool;

	/**
	 * @throws ReflectionException
	 */
	public function buildControllerCallback();

	/**
	 * @throws ReflectionException
	 */
	public function buildMiddlewareCallback(): array;

}
