<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService {
	protected $userRepository;

	public function __construct() {
		$this->userRepository = new UserRepository();
	}

	public function store($attr) {
		$user = $this->userRepository->store($attr);

		//event(UserCreated);
		return $user;
	}
}