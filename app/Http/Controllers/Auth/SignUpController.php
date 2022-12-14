<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Actions\SignUpUserAction;
use Domain\Auth\DTO\SignUpUserDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SignUpController extends Controller
{
    public function index(): View
    {
        return view('auth.signup');
    }

    public function handle(SignUpRequest $request, SignUpUserAction $action): RedirectResponse
    {
        Auth::login($action->handle(SignUpUserDto::fromRequest($request)));

        return Redirect::intended(RouteServiceProvider::HOME);
    }
}
