<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserRole;

class AdminRepository {

	public function all() {
		$admins = User::where('role_id', UserRole::ADMINISTRADOR)
					->get();

		return $admins;
	}

	public function find($id) {
		return User::where('role_id', UserRole::ADMINISTRADOR)->find($id);
	}

	public function store($atributos) {
		return User::create($atributos);
	}

	public function update(User $admin, $atributos) {		
		if (!$admin) {
			return false;
		}

		$admin->update($atributos);

		return $admin;
	}

	public function destroy(User $admin) {
		if ($admin) {
			$admin->delete();
		}

		return true;
	}
}