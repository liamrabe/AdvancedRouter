<?php
namespace LiamRabe\AdvancedRouter\Collection;

use Exception;
use LiamRabe\AdvancedRouter\Exception\InvalidArgumentException;

class ClassStorageHandler {

	protected array $class_store = [];

	/**
	 * @throws InvalidArgumentException
	 */
	public function validateHandlers(string $class_name, string $method_name): void {
		if (!class_exists($class_name)) {
			throw new InvalidArgumentException(sprintf(
				"Provided class '%s' doesn't exist",
				$class_name,
			));
		}

		if (!method_exists($class_name, $method_name)) {
			throw new InvalidArgumentException(sprintf(
				"Method '%s' in class '%s' doesn't exist",
				$method_name, $class_name,
			));
		}
	}

	/**
	 * @throws Exception
	 */
	protected function key(): string {
		return bin2hex(random_bytes(20));
	}

	/**
	 * @throws Exception
	 */
	public function add(string $class_name, string $method_name): string {
		$entry_key = $this->key();

		$this->class_store[$entry_key] = new Collection([
			'class' => $class_name,
			'method' => $method_name,
			'key' => $entry_key,
		]);

		return $entry_key;
	}

	public function remove(string $key): void {
		if (array_key_exists($key, $this->class_store)) {
			unset($this->class_store[$key]);
		}
	}

	/**
	 * @return Collection[]
	 */
	public function all(): array {
		return array_reduce($this->class_store, static function (array $carry, Collection $middleware) {
			$carry[] = [
				$middleware->array()['class'] ?? '',
				$middleware->array()['method'] ?? '',
			];

			return $carry;
		}, []);
	}

}
