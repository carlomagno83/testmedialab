<?php
namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;
use Zend\Db\Adapter\Adapter;
use Zend\Crypt\Password\Bcrypt;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;

use Usuario\Model\Usuario;
use Usuario\Form\LoginForm;
use Usuario\Form\RegistroForm;

use Usuario\Controller\TwitterAPIController;

class UsuarioController extends AbstractActionController
{

    protected $usuarioTable;    
    private $dbAdapter;
    private $auth;

    public function __construct() {

        $this->auth = new AuthenticationService();

    }

    public function getUsuarioTable()
    {

        if (!$this->usuarioTable) {
         $sm = $this->getServiceLocator();
         $this->usuarioTable = $sm->get('Usuario\Model\UsuarioTable');
        }
        return $this->usuarioTable;

    }

    public function indexAction()
    {

         $identi = $this->auth->getStorage()->read();

         if($identi!=false && $identi!=null){

            return new ViewModel(array(
                'usuarios' => $this->getUsuarioTable()->fetchAll(),
            ));


         }else{

                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/login');

         }


    }

    public function registroAction(){

        $this->layout('layout/layout3.phtml');

        $form = new RegistroForm("form");

        if( $this->getRequest()->isPost() ){        
        
            $usuario = new Usuario();
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {

                $usuario->exchangeArray($form->getData());
                $passGen = $this->getUsuarioTable()->saveUsuario($usuario);

                $this->flashMessenger()->addMessage("se envio pass al correo: ".$passGen);

                $para      = $this->getRequest()->getPost('correo');
                $titulo    = 'Registro de Usuario';
                $mensaje   = 'Password: '.$passGen;
                $cabeceras = 'From: mario@medialab.com' . "\r\n" .
                    'Reply-To: no-reply@medialab.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($para, $titulo, $mensaje, $cabeceras);

                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/registro');

            }

        }


        return new ViewModel(

                    array("form"=>$form)

                );

    }    

    public function successAction(){


        return new ViewModel();

    }

    public function tweetsAction(){


        $jsonraw  = $this->getTweets( $this->getEvent()->getRouteMatch()->getParam('id') );
        $rawdata =  $this->getArrayTweets($jsonraw);

        return new ViewModel(
                array("tweets"=>$rawdata)

                );

    }


    public function getTweets($user){

        //ini_set('display_errors', 1);
        //require_once('TwitterAPIExchange.php');

        $settings = array(
            'oauth_access_token' => "2339165102-2qKu5rWwpSqucSrTmxredNDOmHljQcpfiCHpDGe",
            'oauth_access_token_secret' => "n13sg5phdJxrDG8eMaELRQMqqqkC0QvpAkVROQaaoKG1I",
            'consumer_key' => "6630rpmDGYBdtuKoURp8Wi6VY",
            'consumer_secret' => "4qTTMMzy4yxHWoIYNVvd4tSUZELPwf0Px28VerbWqFHG6iU9Z3"
        );

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name='.$user.'&count=100';        
        $requestMethod = 'GET';
        $twitter = new TwitterAPIController($settings);
        $json =  $twitter->setGetfield($getfield)
                             ->buildOauth($url, $requestMethod)
                             ->performRequest();
                return $json;

    }
    

    public function getArrayTweets($jsonraw){

        $rawdata = "";
        $json = json_decode($jsonraw);
        $num_items = count($json);
        for($i=0; $i<$num_items; $i++){

            $user = $json[$i];

            $fecha = $user->created_at;
            $url_imagen = $user->user->profile_image_url;
            $screen_name = $user->user->screen_name;
            $tweet = $user->text;

            //$imagen = "<a href='https://twitter.com/".$screen_name."' target=_blank><img src=".$url_imagen."></img></a>";
            //$name = "<a href='https://twitter.com/".$screen_name."' target=_blank>@".$screen_name."</a>";

            $rawdata[$i]["FECHA"]=$fecha;
            $rawdata[$i]["url_imagen"]=$url_imagen;
            $rawdata[$i]["screen_name"]=$screen_name;
            $rawdata[$i]["tweet"]=$tweet;
        }
        return $rawdata;
    }



    public function loginAction(){

        $this->layout('layout/layout2.phtml');

        $auth = $this->auth;

        $identi = $auth->getStorage()->read();

        if( $identi!=false && $identi!=null ){

            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario');

        }


        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $form = new LoginForm("form");


        if( $this->getRequest()->isPost() ){

            $authAdapter = new AuthAdapter($this->dbAdapter);

            $authAdapter
                ->setTableName('usuario')
                ->setIdentityColumn('correo')
                ->setCredentialColumn('password');

            
            $bcrypt = new Bcrypt(array(
                                'salt' => 'medialab_testing_prueba',
                                'cost' => 5));            
            
            $securePass = $bcrypt->create($this->request->getPost("password"));

            $authAdapter->setIdentity($this->getRequest()->getPost("email"))
                        ->setCredential($securePass);
              
            $auth->setAdapter($authAdapter);

            $result = $auth->authenticate();

            if( $authAdapter->getResultRowObject() == false ){

                $this->flashMessenger()->addMessage("Credenciales incorrectas, intentalo de nuevo");

                return  $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/login');

            }else{
        

                $auth->getStorage()->write($authAdapter->getResultRowObject());

                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario');

           }

        }     
        return new ViewModel(
                array("form"=>$form)

                );

    }


    public function cerrarAction(){

        //Cerramos la sesión borrando los datos de la sesión.

        $this->auth->clearIdentity();

        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/login');

    }


}
