<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // 認証エラーのハンドリング
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('admin/*')) {
                return redirect()->route('admin.login')->with('error', 'ログインが必要です。');
            }
        });

        // モデルが見つからない場合のハンドリング
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->is('admin/*')) {
                return redirect()->back()->with('error', 'データが見つかりませんでした。');
            }
        });

        // 404エラーのハンドリング
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('admin/*')) {
                return redirect()->route('admin.dashboard')->with('error', 'ページが見つかりませんでした。');
            }
        });
    }
} 