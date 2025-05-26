<?php

namespace App\Services;

use App\Repositories\MedicoRepository;
use App\Models\User;
use App\Models\UserRole;
use Tymon\JWTAuth\Facades\JWTAuth;

class MedicoService {
	protected $medicoRepository;

	public function __construct() {
		$this->medicoRepository = new MedicoRepository();
	}

	public function all() {
		$medicos = $this->medicoRepository->all();
		return $medicos;
	}

	public function find(int $id) {
		$medico = $this->medicoRepository->find($id);
		return $medico;
	}

	public function store($atributos) {
		if (!isset($atributos['role_id']) || $atributos['role_id'] != UserRole::MEDICO) {
			$atributos['role_id'] = UserRole::MEDICO;
		}

		$medico = $this->medicoRepository->store($atributos);
		return $medico;
	}

	public function update(User $medico, $atributos) {
		if (!isset($atributos['role_id']) || $atributos['role_id'] != UserRole::MEDICO) {
			$atributos['role_id'] = UserRole::MEDICO;
		}
		
		$medicoAtualizado = $this->medicoRepository->update($medico, $atributos);
		return $medicoAtualizado;
	}

	public function destroy(User $medico) {
		$this->medicoRepository->destroy($medico);
		return true;
	}

	public function getConsultas(User $medico) {
		$consultas = $this->medicoRepository->getConsultas($medico);
		return $consultas;
	}

	public function getPacientes(User $medico) {
		$consultas = $this->getConsultas($medico);
		$pacientes = $consultas->pluck('paciente');

		if ($pacientes) {
			return $pacientes->unique();
		}

		return collect();
	}

	public function me() {
		$user = JWTAuth::parseToken()->authenticate();

		if ($user->role_id != UserRole::MEDICO) {
			return null;
		}

		return $user->append('crm');
	}
}