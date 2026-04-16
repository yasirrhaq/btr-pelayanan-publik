<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        if ($this->isPageExpiredException($e) && !$request->expectsJson()) {
            if ($request->hasSession()) {
                $request->session()->regenerateToken();
            }

            $redirectTo = '/';

            if ($request->is('login')) {
                $redirectTo = route('login', [], false);
            } elseif ($request->is('register')) {
                $redirectTo = '/register';
            } elseif ($request->is('forgot-password')) {
                $redirectTo = route('password.request', [], false);
            }

            return redirect()
                ->to($redirectTo)
                ->withInput($request->except(['password', 'password_confirmation', 'captcha']))
                ->with('authExpired', 'Sesi formulir telah kedaluwarsa. Silakan coba lagi.');
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function isPageExpiredException(Throwable $e): bool
    {
        return $e instanceof TokenMismatchException
            || ($e instanceof HttpExceptionInterface && $e->getStatusCode() === 419);
    }
}
