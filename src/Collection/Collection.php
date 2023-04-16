<?php
namespace LiamRabe\AdvancedRouter\Collection;

use JsonSerializable;

class Collection implements JsonSerializable {

	public function __construct(private array $data = []) {}

	public function get(string $key): mixed {
		return $this->data[$key] ?? null;
	}

	public function set(string $key, mixed $value): void {
		$this->data[$key] = $value;
	}

	private function hasMultiple(array $keys): bool {
		$has_all_fields = true;

		foreach ($keys as $key) {
			if (!$this->has($key)) {
				$has_all_fields = false;
			}
		}

		return $has_all_fields;
	}

	public function has(string|array $key): bool {
		if (is_array($key)) {
			return $this->hasMultiple($key);
		}

		return $this->get($key) !== null;
	}

	public function empty(): bool {
		return empty($this->data);
	}

	public function array(): array {
		return $this->data;
	}

	public function remove(string $key): void {
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
		}
	}

	public function jsonSerialize(): array {
		return $this->array();
	}

}
