<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserRole;

class PacienteRepository {

	public function all() {
		$pacientes = User::where('role_id', UserRole::PACIENTE)
					->get();

		return $pacientes;
	}

	public function find($id) {
		return User::where('role_id', UserRole::PACIENTE)->find($id);
	}

	public function store($atributos) {
		return User::create($atributos);
	}

	public function update(User $paciente, $atributos) {		
		if (!$paciente) {
			return false;
		}

		$paciente->update($atributos);

		return $paciente;
	}

	public function destroy(User $paciente) {
		if ($paciente) {
			$paciente->delete();
		}

		return true;
	}

	public function getConsultas(User $paciente) {
		$consultas = $paciente->consultas->load('medico.crm');
		return $consultas;
	}
}