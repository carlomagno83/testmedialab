<?php
namespace Usuario\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Factory;

class RegistroForm extends Form
{

    public function __construct($name = null)
    {

        parent::__construct($name);

        $this->setAttributes(array(

            'action'=>"",

            'method' => 'post'

        ));

        $this->add(array(

            'name' => 'nombres',

            'attributes' => array(

                'type' => 'text',

                'class' => 'input form-control',

                'required'=>'required'

            )

        ));


        $this->add(array(

            'name' => 'usuario_twitter',

            'attributes' => array(

                'type' => 'text',

                'class' => 'input form-control',

                'required'=>'required'

            )

        ));        


        $this->add(array(

            'name' => 'correo',

            'attributes' => array(

                'type' => 'email',

                'class' => 'input form-control',

                'required'=>'required'

            )

        ));



        $this->add(array(

            'name' => 'submit',

            'attributes' => array(    

                'type' => 'submit',

                'value' => 'Registrar',

                'title' => 'Registrar',

                'class' => 'btn btn-primary'

            ),

        ));


    }

}
