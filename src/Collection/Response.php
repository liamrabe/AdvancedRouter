<?php
namespace LiamRabe\AdvancedRouter\Collection;

class Response {

	public const STATUS_CONTINUE = 100;
	public const STATUS_SWITCHING_PROTOCOLS = 101;
	public const STATUS_PROCESSING = 102;
	public const STATUS_EARLY_HINTS = 103;
	public const STATUS_OK = 200;
	public const STATUS_CREATED = 201;
	public const STATUS_ACCEPTED = 202;
	public const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;
	public const STATUS_NO_CONTENT = 204;
	public const STATUS_RESET_CONTENT = 205;
	public const STATUS_PARTIAL_CONTENT = 206;
	public const STATUS_MULTI_STATUS = 207;
	public const STATUS_ALREADY_REPORTED = 208;
	public const STATUS_IM_USED = 226;
	public const STATUS_MULTIPLE_CHOICES = 300;
	public const STATUS_MOVED_PERMANENTLY = 301;
	public const STATUS_FOUND = 302;
	public const STATUS_SEE_OTHER = 303;
	public const STATUS_NOT_MODIFIED = 304;
	public const STATUS_USE_PROXY = 305;
	public const STATUS_TEMPORARY_REDIRECT = 307;
	public const STATUS_PERMANENT_REDIRECT = 308;
	public const STATUS_BAD_REQUEST = 400;
	public const STATUS_UNAUTHORIZED = 401;
	public const STATUS_PAYMENT_REQUIRED = 402;
	public const STATUS_FORBIDDEN = 403;
	public const STATUS_NOT_FOUND = 404;
	public const STATUS_METHOD_NOT_ALLOWED = 405;
	public const STATUS_NOT_ACCEPTABLE = 406;
	public const STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;
	public const STATUS_REQUEST_TIMEOUT = 408;
	public const STATUS_CONFLICT = 409;
	public const STATUS_GONE = 410;
	public const STATUS_LENGTH_REQUIRED = 411;
	public const STATUS_PRECONDITION_FAILED = 412;
	public const STATUS_PAYLOAD_TOO_LARGE = 413;
	public const STATUS_REQUEST_URI_TOO_LONG = 414;
	public const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
	public const STATUS_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
	public const STATUS_EXPECTATION_FAILED = 417;
	public const STATUS_IM_A_TEAPOT = 418;
	public const STATUS_MISDIRECTED_REQUEST = 421;
	public const STATUS_UNPROCESSABLE_ENTITY = 422;
	public const STATUS_LOCKED = 423;
	public const STATUS_FAILED_DEPENDENCY = 424;
	public const STATUS_UPGRADE_REQUIRED = 426;
	public const STATUS_PRECONDITION_REQUIRED = 428;
	public const STATUS_TOO_MANY_REQUESTS = 429;
	public const STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
	public const STATUS_CONNECTION_CLOSED_WITHOUT_RESPONSE = 444;
	public const STATUS_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
	public const STATUS_CLIENT_CLOSED_REQUEST = 499;
	public const STATUS_INTERNAL_SERVER_ERROR = 500;
	public const STATUS_NOT_IMPLEMENTED = 501;
	public const STATUS_BAD_GATEWAY = 502;
	public const STATUS_SERVICE_UNAVAILABLE = 503;
	public const STATUS_GATEWAY_TIMEOUT = 504;
	public const STATUS_HTTP_VERSION_NOT_SUPPORTED = 505;
	public const STATUS_VARIANT_ALSO_NEGOTIATES = 506;
	public const STATUS_INSUFFICIENT_STORAGE = 507;
	public const STATUS_LOOP_DETECTED = 508;
	public const STATUS_NOT_EXTENDED = 510;
	public const STATUS_NETWORK_AUTHENTICATION_REQUIRED = 511;
	public const STATUS_NETWORK_CONNECT_TIMEOUT_ERROR = 599;

	/** @var string[] */
	protected static array $status_codes = [
		self::STATUS_CONTINUE => 'Continue',
		self::STATUS_SWITCHING_PROTOCOLS => 'Switching Protocols',
		self::STATUS_PROCESSING => 'Processing',
		self::STATUS_EARLY_HINTS => 'Early Hints',
		self::STATUS_OK => 'OK',
		self::STATUS_CREATED => 'Created',
		self::STATUS_ACCEPTED => 'Accepted',
		self::STATUS_NON_AUTHORITATIVE_INFORMATION => 'Non-authoritative Information',
		self::STATUS_NO_CONTENT => 'No Content',
		self::STATUS_RESET_CONTENT => 'Reset Content',
		self::STATUS_PARTIAL_CONTENT => 'Partial Content',
		self::STATUS_MULTI_STATUS => 'Multi-Status',
		self::STATUS_ALREADY_REPORTED => 'Already Reported',
		self::STATUS_IM_USED => 'IM Used',
		self::STATUS_MULTIPLE_CHOICES => 'Multiple Choices',
		self::STATUS_MOVED_PERMANENTLY => 'Moved Permanently',
		self::STATUS_FOUND => 'Found',
		self::STATUS_SEE_OTHER => 'See Other',
		self::STATUS_NOT_MODIFIED => 'Not Modified',
		self::STATUS_USE_PROXY => 'Use Proxy',
		self::STATUS_TEMPORARY_REDIRECT => 'Temporary Redirect',
		self::STATUS_PERMANENT_REDIRECT => 'Permanent Redirect',
		self::STATUS_BAD_REQUEST => 'Bad Request',
		self::STATUS_UNAUTHORIZED => 'Unauthorized',
		self::STATUS_PAYMENT_REQUIRED => 'Payment Required',
		self::STATUS_FORBIDDEN => 'Forbidden',
		self::STATUS_NOT_FOUND => 'Not Found',
		self::STATUS_METHOD_NOT_ALLOWED => 'Method Not Allowed',
		self::STATUS_NOT_ACCEPTABLE => 'Not Acceptable',
		self::STATUS_PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',
		self::STATUS_REQUEST_TIMEOUT => 'Request Timeout',
		self::STATUS_CONFLICT => 'Conflict',
		self::STATUS_GONE => 'Gone',
		self::STATUS_LENGTH_REQUIRED => 'Length Required',
		self::STATUS_PRECONDITION_FAILED => 'Precondition Failed',
		self::STATUS_PAYLOAD_TOO_LARGE => 'Payload Too Large',
		self::STATUS_REQUEST_URI_TOO_LONG => 'Request-URI Too Long',
		self::STATUS_UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
		self::STATUS_REQUESTED_RANGE_NOT_SATISFIABLE => 'Requested Range Not Satisfiable',
		self::STATUS_EXPECTATION_FAILED => 'Expectation Failed',
		self::STATUS_IM_A_TEAPOT => 'I\'m a teapot',
		self::STATUS_MISDIRECTED_REQUEST => 'Misdirected Request',
		self::STATUS_UNPROCESSABLE_ENTITY => 'Unprocessable Entity',
		self::STATUS_LOCKED => 'Locked',
		self::STATUS_FAILED_DEPENDENCY => 'Failed Dependency',
		self::STATUS_UPGRADE_REQUIRED => 'Upgrade Required',
		self::STATUS_PRECONDITION_REQUIRED => 'Precondition Required',
		self::STATUS_TOO_MANY_REQUESTS => 'Too Many Requests',
		self::STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large',
		self::STATUS_CONNECTION_CLOSED_WITHOUT_RESPONSE => 'Connection Closed Without Response',
		self::STATUS_UNAVAILABLE_FOR_LEGAL_REASONS => 'Unavailable For Legal Reasons',
		self::STATUS_CLIENT_CLOSED_REQUEST => 'Client Closed Request',
		self::STATUS_INTERNAL_SERVER_ERROR => 'Internal Server Error',
		self::STATUS_NOT_IMPLEMENTED => 'Not Implemented',
		self::STATUS_BAD_GATEWAY => 'Bad Gateway',
		self::STATUS_SERVICE_UNAVAILABLE => 'Service Unavailable',
		self::STATUS_GATEWAY_TIMEOUT => 'Gateway Timeout',
		self::STATUS_HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
		self::STATUS_VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates',
		self::STATUS_INSUFFICIENT_STORAGE => 'Insufficient Storage',
		self::STATUS_LOOP_DETECTED => 'Loop Detected',
		self::STATUS_NOT_EXTENDED => 'Not Extended',
		self::STATUS_NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required',
		self::STATUS_NETWORK_CONNECT_TIMEOUT_ERROR => 'Network Connect Timeout Error',
	];

	protected static array $error_codes = [
		self::STATUS_BAD_REQUEST => true,
		self::STATUS_UNAUTHORIZED => true,
		self::STATUS_PAYMENT_REQUIRED => true,
		self::STATUS_FORBIDDEN => true,
		self::STATUS_NOT_FOUND => true,
		self::STATUS_METHOD_NOT_ALLOWED => true,
		self::STATUS_NOT_ACCEPTABLE => true,
		self::STATUS_PROXY_AUTHENTICATION_REQUIRED => true,
		self::STATUS_REQUEST_TIMEOUT => true,
		self::STATUS_CONFLICT => true,
		self::STATUS_GONE => true,
		self::STATUS_LENGTH_REQUIRED => true,
		self::STATUS_PRECONDITION_FAILED => true,
		self::STATUS_PAYLOAD_TOO_LARGE => true,
		self::STATUS_REQUEST_URI_TOO_LONG => true,
		self::STATUS_UNSUPPORTED_MEDIA_TYPE => true,
		self::STATUS_REQUESTED_RANGE_NOT_SATISFIABLE => true,
		self::STATUS_EXPECTATION_FAILED => true,
		self::STATUS_IM_A_TEAPOT => true,
		self::STATUS_MISDIRECTED_REQUEST => true,
		self::STATUS_UNPROCESSABLE_ENTITY => true,
		self::STATUS_LOCKED => true,
		self::STATUS_FAILED_DEPENDENCY => true,
		self::STATUS_UPGRADE_REQUIRED => true,
		self::STATUS_PRECONDITION_REQUIRED => true,
		self::STATUS_TOO_MANY_REQUESTS => true,
		self::STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE => true,
		self::STATUS_CONNECTION_CLOSED_WITHOUT_RESPONSE => true,
		self::STATUS_UNAVAILABLE_FOR_LEGAL_REASONS => true,
		self::STATUS_CLIENT_CLOSED_REQUEST => true,
		self::STATUS_INTERNAL_SERVER_ERROR => true,
		self::STATUS_NOT_IMPLEMENTED => true,
		self::STATUS_BAD_GATEWAY => true,
		self::STATUS_SERVICE_UNAVAILABLE => true,
		self::STATUS_GATEWAY_TIMEOUT => true,
		self::STATUS_HTTP_VERSION_NOT_SUPPORTED => true,
		self::STATUS_VARIANT_ALSO_NEGOTIATES => true,
		self::STATUS_INSUFFICIENT_STORAGE => true,
		self::STATUS_LOOP_DETECTED => true,
		self::STATUS_NOT_EXTENDED => true,
		self::STATUS_NETWORK_AUTHENTICATION_REQUIRED => true,
		self::STATUS_NETWORK_CONNECT_TIMEOUT_ERROR => true,
	];

	protected int $status_code = 200;
	protected array $headers = [];
	protected string $body = '';

	public function getHeaders(): array {
		return $this->headers;
	}

	public function getHeader(string $header): string {
		return $this->headers[$header] ?? '';
	}

	public function setHeader(string $header, string $value): self {
		$this->headers[$header] = $value;
		return $this;
	}

	public function setStatusCode(int $status_code): self {
		$this->status_code = $status_code;
		return $this;
	}

	public function getStatusCode(): int {
		return $this->status_code ?? static::STATUS_OK;
	}

	public function getCodes(): array {
		return static::$status_codes;
	}

	public function getBody(): string {
		return $this->body;
	}

	public function setBody(string $body): self {
		$this->body = $body;
		return $this;
	}

	public function getStatusCodes(): array {
		return self::$status_codes;
	}

	public function getErrorCodes(): array {
		return self::$error_codes;
	}

	public function getSuccessCodes(): array {
		return array_diff_key(self::$status_codes, self::$error_codes);
	}

}
