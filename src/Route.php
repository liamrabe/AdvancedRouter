<?php
namespace LiamRabe\AdvancedRouter;

use LiamRabe\AdvancedRouter\Collection\Collection;
use LiamRabe\AdvancedRouter\Exception\InvalidArgumentException;
use LiamRabe\AdvancedRouter\Interface\IRoute;
use Closure;
use ReflectionException;
use ReflectionFunction;

class Route implements IRoute {

	protected const ARGUMENT_SEARCH = '/{(\w+):([\w\-_+\[\].\\\]+)}/';

	public function __construct(
		protected string $method,
		protected string $uri,
		protected Closure|array $callback,
		protected array $middleware,
	) {}

	public function getURI(): string {
		return $this->uri;
	}

	public function getMethod(): string {
		return $this->method;
	}

	public function getCallback(): string|array|callable {
		return $this->callback;
	}

	public function getMiddleware(): array {
		return $this->middleware;
	}

	public function getParameters(string $uri): Collection {
		$uri_parts = explode('/', $this->uri, 100);
		$current_uri_parts = explode('/', $uri, 100);

		if (count($uri_parts) !== count($current_uri_parts)) {
			return new Collection([]);
		}

		$parameters = [];

		foreach (array_combine($uri_parts, $current_uri_parts) as $part => $current_uri_part) {
			if (str_starts_with($part, ':')) {
				$parameter_name = substr($part, 1);

				if (isset($current_uri_part)) {
					$parameters[$parameter_name] = $current_uri_part;
				}
			} else {
				if (isset($current_uri_part)) {
					$matches = [];

					if (preg_match_all(static::ARGUMENT_SEARCH, $part, $matches)) {
						$name = $matches[1][0];
						$parameters[$name] = $current_uri_part;
					}
				}
			}
		}

		return new Collection($parameters);
	}

	public function match(string $uri): bool {
		$uri_parts = array_filter(explode('/', $this->uri, 100));
		$current_uri_parts = array_filter(explode('/', $uri, 100));

		if (count($uri_parts) !== count($current_uri_parts)) {
			return false;
		}

		foreach (array_combine($uri_parts, $current_uri_parts) as $part => $current_uri_part) {
			if (!str_starts_with($part, ':')) {
				if (isset($current_uri_part)) {
					$matches = [];

					if (preg_match_all(static::ARGUMENT_SEARCH, $part, $matches)) {
						$regex = $matches[2][0];

						if (!preg_match('/^' . $regex . '$/', $current_uri_part)) {
							return false;
						}
					} else {
						if ($part !== $current_uri_part) {
							return false;
						}
					}
				} else {
					return false;
				}
			}
		}

		return true;
	}

	private function validateCallback(array|Closure $callback): void {
		if (!$callback instanceof Closure && !class_exists($callback[0] ?? '')) {
			throw new InvalidArgumentException(sprintf(
				"Class '%s' doesn't exist",
				$callback[0] ?? '',
			), 500);
		}

		if (!$callback instanceof Closure && !method_exists($callback[0] ?? '', $callback[1] ?? '')) {
			throw new InvalidArgumentException(sprintf(
				"Callback method '%s' doesn't exist in class %s",
				$callback[1] ?? '',
				$callback[0] ?? '',
			), 500);
		}
	}

	/**
	 * @throws ReflectionException|InvalidArgumentException
	 */
	public function buildCallback(array|Closure $callback): array|string|Closure {
		if ($callback instanceof Closure) {
			$reflection_function = new ReflectionFunction($callback);

			if (!$reflection_function->getClosureScopeClass()) {
				return $callback;
			}

			$closure_class = $reflection_function->getClosureScopeClass()->getName();
			$closure_method_name = $reflection_function->getName();

			if (!$reflection_function->isStatic()) {
				$closure_class = new $closure_class();
			}
		} else {
			$closure_class = new $callback[0] ?? ''();
			$closure_method_name = $callback[1] ?? '';
		}

		$this->validateCallback($callback);

		return [$closure_class, $closure_method_name];
	}

	/**
	 * @throws ReflectionException|InvalidArgumentException
	 */
	public function buildControllerCallback(): array|Closure {
		return $this->buildCallback($this->callback);
	}

	/**
	 * @throws ReflectionException|InvalidArgumentException
	 */
	public function buildMiddlewareCallback(): array {
		return $this->buildCallback($this->middleware);
	}

	/**
	 * @return array
	 */
	public function getMiddlewares(): array {
		return $this->middleware;
	}

}
