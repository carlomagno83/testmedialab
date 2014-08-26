<?php
namespace Usuario\Model;

use Zend\Crypt\Password\Bcrypt;
use Zend\Db\TableGateway\TableGateway;

class UsuarioTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {

         $resultSet = $this->tableGateway->select();
         return $resultSet;

    }

    public function getUsuario($id)
    {

        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
         throw new \Exception("Could not find row $id");
        }
        return $row;

    }

    public function saveUsuario(Usuario $usuario)
    {

        $bcrypt = new Bcrypt(array(
                            'salt' => 'medialab_testing_prueba',
                            'cost' => 5));    

        $passGen = $this->generatePass();

        $securePass = $bcrypt->create( $passGen );        

        $data = array(
         'nombres' => $usuario->nombres,
         'usuario_twitter'  => $usuario->usuario_twitter,
         'correo' => $usuario->correo,
         'password'  => $securePass         
        );

        $id = (int) $usuario->id;
        if ($id == 0) {

            $this->tableGateway->insert($data);
            return $passGen;

        }

    }


    public function generatePass($length = 6){

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;

    }    

}