<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use App\Models\User;
use App\Models\UserRole;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminService {
	protected $adminRepository;
	protected $medicoService;

	public function __construct() {
		$this->adminRepository = new AdminRepository();
		$this->medicoService = new MedicoService();
	}

	public function all() {
		return $this->adminRepository->all();
	}

	public function find(int $id) {
		return $this->adminRepository->find($id);
	}

	public function store($atributos) {
		$atributos['role_id'] = UserRole::ADMINISTRADOR;
		$admin = $this->adminRepository->store($atributos);
		return $admin;
	}

	public function update(User $admin, $atributos) {
		$atributos['role_id'] = UserRole::ADMINISTRADOR;
		$adminAtualizado = $this->adminRepository->update($admin, $atributos);
		return $adminAtualizado;
	}

	public function destroy(User $admin) {
		if ($admin->role_id != UserRole::ADMINISTRADOR) {
			throw new NotFoundHttpException();
		}

		return $this->adminRepository->destroy($admin);
	}

	public function getConsultas(User $admin) {
		$consultas = $this->adminRepository->getConsultas($admin);
		return $consultas;
	}
}