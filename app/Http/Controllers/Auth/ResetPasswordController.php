<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Domain\Auth\Actions\ResetPasswordAction;
use Domain\Auth\DTO\ResetPasswordDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function index(string $token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function handle(ResetPasswordRequest $request, ResetPasswordAction $action): RedirectResponse
    {
        $status = $action->handle(ResetPasswordDto::fromArray($request->validated()));

        if ($status !== Password::PASSWORD_RESET) {
            $errors = ['email' => __($status)];

            return back()->withErrors($errors);
        }

        flash()->info(__($status));

        return to_route('signin.index');
    }
}