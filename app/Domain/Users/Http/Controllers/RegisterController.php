<?php

namespace App\Domain\Users\Http\Controllers;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Http\Requests\RegisterUserRequest;
use App\Interfaces\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->middleware('guest');
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->create($request->only(['full_name', 'email', 'password', 'locale']));
    }

    protected function create(array $data)
    {
        return $this->userRepository->store([
            'email'                       => $data['email'],
            'full_name'                   => $data['name'],
            'email_token_confirmation'    => Uuid::uuid4()->toString(),
            'email_token_disable_account' => Uuid::uuid4()->toString(),
            'password'                    => bcrypt($data['password']),
            'is_active'                   => 1,
            'email_verified_at'           => null,
            'locale'                      => $data['locale'] ?? 'en_US',
        ]);
    }
}
