<?php
namespace Usuario\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Factory;

class LoginForm extends Form
{

    public function __construct($name = null)
    {

        parent::__construct($name);

        $this->setAttributes(array(

            'action'=>"",

            'method' => 'post'

        ));

        $this->add(array(

            'name' => 'email',

            'attributes' => array(

                'type' => 'email',

                'class' => 'input form-control',

                'required'=>'required'

            )

        ));

         $this->add(array(

            'name' => 'password',

            'attributes' => array(

                'type' => 'password',

                'class' => 'input form-control',

                'required'=>'required'

            )

        ));

        $this->add(array(

            'name' => 'submit',

            'attributes' => array(    

                'type' => 'submit',

                'value' => 'Ingresar',

                'title' => 'Ingresar',

                'class' => 'btn btn-primary'

            ),

        ));


    }

}
