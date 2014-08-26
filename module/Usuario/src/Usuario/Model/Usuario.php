<?php
namespace Usuario\Model;

class Usuario
{

	public $id;
	public $nombres;
	public $usuario_twitter;
	public $correo;	
	public $password;	

	public function exchangeArray($data)
	{

		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->nombres = (!empty($data['nombres'])) ? $data['nombres'] : null;
		$this->usuario_twitter  = (!empty($data['usuario_twitter'])) ? $data['usuario_twitter'] : null;
		$this->correo  = (!empty($data['correo'])) ? $data['correo'] : null;
		$this->password  = (!empty($data['password'])) ? $data['password'] : null;						

	}

}