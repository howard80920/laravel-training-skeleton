<?php

namespace App\Exceptions;

use Exception;

class CommonException extends Exception
{

    protected $args = [];

    public function __construct(
        $message = '',
        $status = 400,
        array $args = []
    ) {
        $this->args = $args;
        parent::__construct($message, $status);
    }
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response(
            [ 'message' => $this->message ] + $this->args,
            $this->code
        );
    }

    public static function trans(int $status, string $transKey, ?array $replaces = null, array $args = [])
    {
        return new static(
            __($transKey, $replaces ?? []),
            $status,
            $args + [ 'message_key' => $transKey ]
        );
    }

    public static function modelNotFound(string $modelName, array $args = [])
    {
        return static::trans(
            404,
            'message.model_not_found',
            [ 'm' => $modelName ],
            $args
        );
    }
}
