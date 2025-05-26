<?php

namespace App\Services;

use App\Repositories\ConsultaRepository;
use App\Models\Consulta;
use App\Models\UserRole;
use App\Services\MedicoService;
use App\Services\PacienteService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Auth;
use \Exception as Exception;

class ConsultaService {
	protected $consultaRepository;
	protected $medicoService;
	protected $pacienteService;

	public function __construct() {
		$this->consultaRepository = new ConsultaRepository();
		$this->medicoService = new MedicoService();
		$this->pacienteService = new PacienteService();
	}

	public function all() {
		$user = JWTAuth::parseToken()->authenticate();

		switch($user->role_id) {
			case UserRole::ADMINISTRADOR:
				$consultas = $this->consultaRepository->all();
				break;
			case UserRole::MEDICO:
				$consultas = $this->medicoService->consultas($user);
				break;
			case UserRole::PACIENTE:
				$consultas = $this->pacienteService->consultas($user);
				break;
		}

		return $consultas;
	}

	public function find(int $id) {
		$consulta = $this->consultaRepository->find($id);
		return $consulta;
	}

	public function store($atributos) {
		$user = Auth::user();
		$medico = $this->medicoService->find($atributos['medico_id']);

		if (!isset($atributos['paciente_id']) && $user->role_id == UserRole::PACIENTE) {
			$atributos['paciente_id'] = $user->id;
		} 

		if (($user->role_id == UserRole::PACIENTE && $user->id != $atributos['paciente_id']) || !$medico){
			throw new AccessDeniedHttpException();
		}

		$consulta = $this->consultaRepository->store($atributos);
		return $consulta;
	}

	public function update(Consulta $consulta, $atributos) {
		$user = Auth::user();
		$medico = $this->medicoService->find($atributos['medico_id']);

		if (!isset($atributos['paciente_id']) && $user->role_id == UserRole::PACIENTE) {
			$atributos['paciente_id'] = $user->id;
		} 

		$consultaAtualizado = $this->consultaRepository->update($consulta, $atributos);
		return $consultaAtualizado;
	}

	public function destroy(Consulta $consulta) {
		$this->consultaRepository->destroy($consulta);
		return true;
	}
}