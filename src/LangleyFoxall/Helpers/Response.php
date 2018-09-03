<?php
namespace LangleyFoxall\Helpers;

use Illuminate\Http\Request;

class Response
{
	/** @var Request $request */
	private $request;

	/** @var string $type */
	private $type;

	/** @var string $message */
	private $message;

	/** @var array $data */
	private $data;

	/** @var array $meta */
	private $meta;

	/** @var int $status */
	private $status;

	/** @var string $uri */
	private $uri;

	/**
	 * Response constructor.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * @param string $message
	 * @param array  $data
	 * @param array  $meta
	 * @param int    $status
	 * @return $this
	 */
	public function success(string $message = null, array $data = null, array $meta = null, int $status = 200)
	{
		$this->type    = 'success';
		$this->message = $message;
		$this->data    = $data;
		$this->meta    = $meta;
		$this->status  = $status;

		return $this;
	}

	/**
	 * @param mixed $message
	 * @param int   $status
	 * @return $this
	 */
	public function error($message = null, int $status = 400)
	{
		$this->type    = 'error';
		$this->message = $message;
		$this->status  = $status;

		return $this;
	}

	public function type(string $type)
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * @param string $message
	 * @return $this
	 */
	public function message(string $message)
	{
		$this->message = $message;

		return $this;
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function data(array $data = null)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * @param array $meta
	 * @return $this
	 */
	public function meta(array $meta = null)
	{
		$this->meta = $meta;

		return $this;
	}

	/**
	 * @param int $status
	 * @return $this
	 */
	public function status(int $status)
	{
		$this->status = $status;

		return $this;
	}

	/**
	 * @param string $uri
	 * @return $this
	 */
	public function redirect(string $uri = null)
	{
		$this->uri = $uri;

		return $this;
	}

	/**
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function end()
	{
		$type    = $this->type;
		$message = $this->message;
		$status  = $this->status;
		$data    = $this->data;
		$meta    = $this->meta;

		if ($this->request->expectsJson()) {
			if ($type === 'error') {
				return ApiResponse::error($message, $status)->json();
			}

			return ApiResponse::success($data, $meta, $status)->json();
		}


		if ($this->uri) {
			return redirect($this->uri);
		}

		return back()->with($type, $message);
	}
}
