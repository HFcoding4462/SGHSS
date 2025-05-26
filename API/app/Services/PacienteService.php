<?php

namespace App\Services;

use App\Repositories\PacienteRepository;
use App\Models\User;
use App\Models\UserRole;
use Tymon\JWTAuth\Facades\JWTAuth;

class PacienteService {
	protected $PacienteRepository;
	protected $medicoService;

	public function __construct() {
		$this->pacienteRepository = new PacienteRepository();
		$this->medicoService = new MedicoService();
	}

	public function all() {
		$user = JWTAuth::parseToken()->authenticate();
		$userRole = $user->role_id;
		$pacientes;
		
		switch ($userRole) {
			case UserRole::ADMINISTRADOR:
				$pacientes = $this->pacienteRepository->all();
				break;
			case UserRole::MEDICO:
				$pacientes = $this->medicoService->getPacientes($user); //medicoRepository
				break;
			case UserRole::PACIENTE:
				$pacientes = $user;
				break;
		}

		return $pacientes;
	}

	public function find(int $id) {
		$paciente = $this->pacienteRepository->find($id);
		return $paciente;
	}

	public function store($atributos) {
		if (!isset($atributos['role_id']) || $atributos['role_id'] != UserRole::PACIENTE) {
			$atributos['role_id'] = UserRole::PACIENTE;
		}

		$paciente = $this->pacienteRepository->store($atributos);
		return $paciente;
	}

	public function update(User $paciente, $atributos) {
		if (!isset($atributos['role_id']) || $atributos['role_id'] != UserRole::PACIENTE) {
			$atributos['role_id'] = UserRole::PACIENTE;
		}

		$pacienteAtualizado = $this->pacienteRepository->update($paciente, $atributos);
		return $pacienteAtualizado;
	}

	public function destroy(User $paciente) {
		return $this->pacienteRepository->destroy($paciente);
	}

	public function getConsultas(User $paciente) {
		$consultas = $this->pacienteRepository->getConsultas($paciente);
		return $consultas;
	}

	public function me() {
		$user = JWTAuth::parseToken()->authenticate();

		if ($user->role_id != UserRole::PACIENTE) {
			return null;
		}

		return $user;
	}
}