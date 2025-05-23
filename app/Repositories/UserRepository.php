<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {

	public function find($id) {
		return User::find($id);
	}

	public function store($attr) {
		return User::create($attr);
	}
}