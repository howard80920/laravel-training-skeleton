<?php

namespace App\Exceptions;

use Exception;

class InertiaCommonException extends Exception
{

    public function __construct(
        $message = '',
        $status = 400
    ) {
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return back(302, [], route('office.error', []))
        ->with('error', $this->getCode())
        ->with('message', $this->getMessage());
    }

    public static function modelNotFound(?string $modelName)
    {
        return new static(
            __('message.model_not_found', [ 'm' => $modelName ?? '' ]),
            404
        );
    }
}
