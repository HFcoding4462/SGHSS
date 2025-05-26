<?php

namespace App\Repositories;

use App\Models\Consulta;
use App\Models\UserRole;

class ConsultaRepository {

	public function all() {
		$consultas = Consulta::get();

		return $consultas;
	}

	public function find($id) {
		return Consulta::find($id);
	}

	public function store($atributos) {
		$consulta = Consulta::create($atributos);

		if (!$consulta) {
			return null;
		}

		return $consulta;
	}

	public function update($consulta, $atributos) {		
		if (!$consulta) {
			return false;
		}

		$consulta->update($atributos);

		return $consulta;
	}

	public function destroy($consulta) {
		if ($consulta) {
			$consulta->delete();
		}

		return true;
	}
}