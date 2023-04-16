<?php
namespace LiamRabe\AdvancedRouter\Collection;

class Request {

	protected function __construct(
		protected array $get,
		protected array $post,
		protected array $cookies,
		protected array $server,
		protected array $session,
		protected array $files,
		protected array $headers,
		protected ?Collection $named_parameters = null,
		protected Collection $store = new Collection(),
	) {}

	public function cookies(): Collection {
		return new Collection($this->cookies);
	}

	public function server(): Collection {
		return new Collection($this->server);
	}

	public function post(): Collection {
		return new Collection($this->post);
	}

	public function get(): Collection {
		return new Collection($this->get);
	}

	public function files(): Collection {
		return new Collection($this->files);
	}

	public function headers(): Collection {
		return new Collection($this->headers);
	}

	public function session(): Collection {
		return new Collection($this->session);
	}

	public function parameters(): Collection {
		return $this->named_parameters;
	}

	public function method(): string {
		return $this->server()->get('REQUEST_METHOD');
	}

	public function uri(): string {
		return $this->server()->get('REQUEST_URI');
	}

	public function store(): Collection {
		return $this->store;
	}

	/* Static methods */

	public static function createFromGlobals(?Collection $named_parameters = null): self {
		return new self(
			$_GET ?? [],
			$_POST ?? [],
			$_COOKIE ?? [],
			$_SERVER ?? [],
			$_SESSION ?? [],
			$_FILES ?? [],
			request_headers(),
			$named_parameters ?? new Collection(),
		);
	}

}
