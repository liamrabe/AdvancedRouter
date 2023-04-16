<?php
namespace LiamRabe\AdvancedRouter;

use Closure;
use LiamRabe\AdvancedRouter\Collection\ClassStorageHandler;
use LiamRabe\AdvancedRouter\Exception\InvalidArgumentException;
use LiamRabe\AdvancedRouter\Exception\RouterException;
use LiamRabe\AdvancedRouter\Interface\IRoute;
use LiamRabe\AdvancedRouter\Collection\Request;
use LiamRabe\AdvancedRouter\Collection\Response;
use LiamRabe\AdvancedRouter\Exception\HTTPException;
use LiamRabe\App\Exception\Exception;
use ReflectionException;

class Router {

	public const METHOD_GET = 'GET';
	public const METHOD_PUT = 'PUT';
	public const METHOD_PATCH = 'PATCH';
	public const METHOD_POST = 'POST';
	public const METHOD_DELETE = 'DELETE';

	private const SUPPORTED_HTTP_METHODS = [
		self::METHOD_GET => true,
		self::METHOD_PUT => true,
		self::METHOD_POST => true,
		self::METHOD_PATCH => true,
		self::METHOD_DELETE => true,
	];

	protected const VERSION = '1.0.0';

	protected string $error_controller_class;
	protected string $error_controller_method;

	protected ClassStorageHandler $middleware_class_storage;
	protected ClassStorageHandler $error_handler_class_storage;

	/* Route */

	protected array $routes = [];
	protected string $route_class = Route::class;

	/* Router */

	protected bool $include_trailing_slash = true;
	protected array $headers = [];
	protected string $uri = '';

	public function __construct() {
		$this->error_handler_class_storage = new ClassStorageHandler();
		$this->middleware_class_storage = new ClassStorageHandler();
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function setErrorController(string $class_name, string $method_name): void {
		$this->middleware_class_storage->validateHandlers($class_name, $method_name);

		$this->error_controller_method = $method_name;
		$this->error_controller_class = $class_name;
	}

	/**
	 * @throws InvalidArgumentException|\Exception
	 */
	public function setMiddleware(string $class_name, string $method_name): string {
		return $this->middleware_class_storage->add($class_name, $method_name);
	}

	public function setIncludeTrailingSlash(bool $include_trailing_slash): void {
		$this->include_trailing_slash = $include_trailing_slash;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	protected function validateRouteCreation(): void {
		foreach ($this->middleware_class_storage->all() as $middleware) {
			if (!$middleware) {
				throw new InvalidArgumentException('Middleware required before creating routes', 500);
			}
		}

		$controller = $this->error_controller_class ?? null;
		if (!$controller) {
			throw new InvalidArgumentException('Error controller required before creating routes', 500);
		}

		$route = $this->route_class ?? null;
		if (!$route) {
			throw new InvalidArgumentException('Route required before creating routes', 500);
		}

		$route = new $this->route_class('', '', static function() {}, []);
		if (!$route instanceof IRoute) {
			throw new InvalidArgumentException(sprintf('Route has to be of type %s', IRoute::class));
		}
	}

	public function setRoute(string $route_class): void {
		$this->route_class = $route_class;
	}

	public function setHeaders(array $headers): void {
		$this->headers = array_merge($this->headers, $headers);
	}

	public function setHeader(string $key, string $value): void {
		$this->headers[$key] = $value;
	}

	public function redirect(string $uri, string $target, int $status_code = 301): void {
		$current_uri = sprintf('%s%s', $this->uri, $uri);

		if ($this->uri() === $current_uri) {
			header(sprintf('Location: %s', $target), true, $status_code);
			exit;
		}
	}

	public function routes(): array {
		return $this->routes;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function addRoute(string $method, string $uri, array|callable $handler, ?bool $include_trailing_slash = null): IRoute {
		$this->validateRouteCreation();

		if ($method !== 'ALL' && !in_array($method, static::SUPPORTED_HTTP_METHODS)) {
			throw new InvalidArgumentException(sprintf(
				"HTTP Method '%s' isn't supported",
				$method,
			));
		}

		if (is_callable($handler)) {
			$handler = $handler(...);
		}

		if ($include_trailing_slash === null) {
			$include_trailing_slash = $this->include_trailing_slash;
		}

		if ($include_trailing_slash && !str_ends_with($uri, '/')) {
			$this->addRoute($method, $uri . '/', $handler, false);
		}

		$uri = $this->uri . $uri;

		return $this->routes[] = new $this->route_class($method, $uri, $handler, $this->middleware_class_storage->all());
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function all(string $uri, array|callable $callable, bool $include_trailing_slash = true): Route {
		return $this->addRoute('ALL', $uri, $callable, $include_trailing_slash);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function get(string $uri, array|callable $callable, bool $include_trailing_slash = true): Route {
		return $this->addRoute('GET', $uri, $callable, $include_trailing_slash);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function put(string $uri, array|callable $callable, bool $include_trailing_slash = true): Route {
		return $this->addRoute('PUT', $uri, $callable, $include_trailing_slash);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function post(string $uri, array|callable $callable, bool $include_trailing_slash = true): Route {
		return $this->addRoute('POST', $uri, $callable, $include_trailing_slash);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function patch(string $uri, array|callable $callable, bool $include_trailing_slash = true): Route {
		return $this->addRoute('PATCH', $uri, $callable, $include_trailing_slash);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function delete(string $uri, array|callable $callable, bool $include_trailing_slash = true): Route {
		return $this->addRoute('DELETE', $uri, $callable, $include_trailing_slash);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function group(string $uri, Closure $callable, ?array $middleware = null): void {
		$middleware_keys = [];

		if ($middleware) {
			foreach ($middleware as $mw) {
				$key = $this->setMiddleware($mw[0] ?? '', $mw[1] ?? '');
				$middleware_keys[$key] = true;
			}
		}

		$this->uri = sprintf('%s%s', $this->uri, $uri);
		$callable($this);
		$this->uri = rtrim($this->uri, $uri);

		if ($middleware) {
			foreach ($middleware_keys as $key => $ignored) {
				$this->middleware_class_storage->remove($key);
			}
		}
	}

	protected function method(): string {
		return $_SERVER['REQUEST_METHOD'];
	}

	protected function uri(): string {
		$parts = explode('?', $_SERVER['REQUEST_URI']);
		return array_shift($parts);
	}

	public function getControllerParameters(Route $route): array {
		return [
			Request::createFromGlobals($route->getParameters($this->uri())),
			new Response(),
		];
	}

	/**
	 * @throws ReflectionException|InvalidArgumentException
	 */
	public function run(): void {
		try {
			$routes = array_filter($this->routes, function(Route $route) {
				return
					($route->getMethod() === 'ALL' || $this->method() === $route->getMethod()) &&
					$route->match($this->uri()
				);
			});

			/** @var Route $route */
			$route = end($routes);

			if (empty($matched_routes) && is_bool($route) && !$route) {
				throw new HTTPException(sprintf(
					"The requested URI '%s' doesn't exist",
					$this->uri(),
				), 404);
			}

			[$request, $response] = $this->getControllerParameters($route);

			foreach ($route->getMiddlewares() as $middleware) {
				/**
				 * Will throw an exception
				 */
				call_user_func_array($route->buildCallback($middleware), [
					$request
				]);
			}

			$response = call_user_func_array($route->buildControllerCallback(), [$request, $response]);
			$this->handleOutput($route, $request, $response);
		} catch (RouterException $ex) {
			$this->handleException($ex);
		}
	}

	/**
	 * @throws ReflectionException
	 * @throws InvalidArgumentException
	 */
	public function handleException(\Exception $ex): void {
		/** @var Route $error_route */
		$error_route = new $this->route_class('GET', $this->uri, [
			$this->error_controller_class,
			$this->error_controller_method,
		], []);

		$request = Request::createFromGlobals();
		$request->store()->set('router', $this);

		$response = call_user_func_array($error_route->buildControllerCallback(), [ $ex ]);
		$this->handleOutput(null, $request, $response);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function handleOutput(?Route $route = null, ?Request $request = null, ?object $response = null): void {
		if (!$response instanceof Response) {
			throw new InvalidArgumentException(sprintf(
				"Response has to be instance of class '%s'",
				Response::class,
			), 500);
		}

		/* Process response from controller */
		http_response_code($response->getStatusCode());

		$headers = array_merge($this->headers, $response->getHeaders());

		foreach ($headers as $header => $value) {
			header(sprintf('%s: %s', $header, $value), true, $response->getStatusCode());
		}

		echo $response->getBody();
	}

	public function version(bool $split = false): array|string {
		if ($split) {
			$version = explode('.', static::VERSION);

			return [
				'major' => trim($version[0] ?? '1'),
				'minor' => trim($version[1] ?? '0'),
				'patch' => trim($version[2] ?? '0'),
			];
		}

		return sprintf('v%s', static::VERSION);
	}

}
