<?php

namespace App\Repositories;

use App\Models\CRM;
use App\Models\User;
use App\Models\UserRole;

class MedicoRepository {

	public function all() {
		$medicos = User::where('role_id', UserRole::MEDICO)
					->get()
					->append('crm');

		return $medicos;
	}

	public function find($id) {
		$medico = User::where('role_id', UserRole::MEDICO)->find($id);//->append('crm');

		if (!$medico) {
			return false;
		}

		return $medico->append('crm');
	}

	public function store($atributos) {
		$crm = $atributos['crm'];
		$medico = User::create($atributos);

		if ($medico) {
			$crm = CRM::create(['crm' => $crm]);
		} else {
			return;
		}

		$crm->medico()->associate($medico)->save();
		return $medico->append('crm');
	}

	public function update($medico, $atributos) {		
		if (!$medico) {
			return false;
		}

		$medico->update($atributos);

		return $medico->append('crm');
	}

	public function destroy($medico) {
		if ($medico) {
			$medico->delete();
		}

		return true;
	}

	public function getConsultas(User $medico) {
		return $medico->consultas->load('paciente');
	}
}