<?php
require (dirname(__DIR__)."/modelo.php");


class Sistema extends Modelo {

    public function __construct(){
        parent::__construct();
    }

    public function registrarUsuario(){
        $mensajeErrores = array();

    	//Recibo el dato y lo decodifico
    	$json = $_REQUEST['datos'];
    	$datos = json_decode($json, true);

    	//Guardo en variable cada dato.
		$nombre = $datos["nombre"];
    	$apellido = $datos["apellido"];
    	$usuario = $datos["usuario"];
    	$pass = $datos["pass"];
    	$repass = $datos["repass"];
    	$tipo_dni = $datos["tipo_dni"];
    	$numero_dni = $datos["numero_dni"];
    	$calle = $datos["calle"];
    	$altura = $datos["altura"];
    	$depto = $datos["depto"];
    	$partido = $datos["partido"];
    	$provincia = $datos["provincia"];
    	$telefono = $datos["telefono"];
    	$celular = $datos["celular"];
    	$mail = $datos["mail"];



    	//Valido los datos
        if(preg_match("/^[a-zA-ZñÑáéíóÁÉÍÓÚ]*$/",$nombre))
        {
            $mensajeErrores["nombre"] = 0;
        }else
        {
           $mensajeErrores["nombre"] = "El nombre no es correcto"; 
        }

        if(preg_match("/^[a-zA-ZñÑáéíóÁÉÍÓÚ]*$/",$apellido))
        {
            $mensajeErrores["apellido"] = 0;
        }else
        {
           $mensajeErrores["apellido"] = "El apellido no es correcto"; 
        }

        if(preg_match("//",$usuario))
        {
            $mensajeErrores["usuario"] = 0;
        }else
        {
           $mensajeErrores["usuario"] = "El nombre de usuario no es correcto"; 
        }

        if(preg_match("/[\w]{6,}/",$pass))
        {
            $mensajeErrores["pass"] = 0;
        }else
        {
           $mensajeErrores["pass"] = "La contraseña no es correcta"; 
        }

        if($repass == $pass)
        {
            $mensajeErrores["repass"] = 0;
        }else
        {
           $mensajeErrores["repass"] = "Las contraseñas no coinciden"; 
        }

        if(preg_match("//",$tipo_dni))
        {
            $mensajeErrores["tipo_dni"] = 0;
        }else
        {
           $mensajeErrores["tipo_dni"] = "Por favor seleccione un tipo de DNI"; 
        }

        if(preg_match("/^([1-9][0-9]{6}|[1-9][0-9]{7})$/",$numero_dni))
        {
            $mensajeErrores["numero_dni"] = 0;
        }else
        {
           $mensajeErrores["numero_dni"] = "El número de DNI no es válido"; 
        }

        if(preg_match("/^[0-9a-zA-ZñÑáéíóÁÉÍÓÚ ]*/",$calle))
        {
            $mensajeErrores["calle"] = 0;
        }else
        {
           $mensajeErrores["calle"] = "La calle ingresada no es válida"; 
        }

        if(preg_match("/[0-9]+/",$altura))
        {
            $mensajeErrores["altura"] = 0;
        }else
        {
           $mensajeErrores["altura"] = "La altura ingresada no es válida"; 
        }

        if(preg_match("/[0-9]+/",$depto))
        {
            $mensajeErrores["depto"] = 0;
        }else
        {
           $mensajeErrores["depto"] = "El número de departamento no es válido"; 
        }

        if(preg_match("/^[0-9a-zA-ZñÑáéíóÁÉÍÓÚ ]*$/",$partido))
        {
            $mensajeErrores["partido"] = 0;
        }else
        {
           $mensajeErrores["partido"] = "El partido ingresado no es válido"; 
        }

        if(preg_match("//",$provincia))
        {
            $mensajeErrores["provincia"] = 0;
        }else
        {
           $mensajeErrores["provincia"] = "Por favor seleccione una provincia"; 
        }

        if(preg_match("/[0-9]+/",$telefono))
        {
            $mensajeErrores["telefono"] = 0;
        }else
        {
           $mensajeErrores["telefono"] = "El télefono ingresado no es válido"; 
        }

        if(preg_match("/[0-9]+/",$celular))
        {
            $mensajeErrores["celular"] = 0;
        }else
        {
           $mensajeErrores["celular"] = "El número de celular ingresado no es válido"; 
        }

        if(preg_match("/^[a-zA-Z0-9_ñÑáéíóÁÉÍÓÚ]*[@]+[a-z]+([.]{1}[a-z]+)*$/",$mail))
        {
            $mensajeErrores["mail"] = 0;
        }else
        {
           $mensajeErrores["mail"] = "El mail ingresado no es válido"; 
        }


        //Verifico si hay errores.

        $hayError = false;
        $mensajeDeError = "";
        foreach($mensajeErrores as $error){

            if( $error !== 0 )
            {
                $hayError = true;
                $mensajeDeError = $mensajeDeError . $error."<br>";
            }
        }

        if($hayError)
        {
            //Informo que hay errores y el mensaje de error
            echo $mensajeDeError;

        }else
        {
            //Verifico que el mail y nombre de usuario no estén en uso

            $consultaUsuario = "SELECT nombre_usuario FROM USUARIOS WHERE nombre_usuario = '$usuario' ";

            $resultado = $this->db->query($consultaUsuario) or die("Error en el SELECT USUARIO: ".mysqli_error($this->db));

            if($resultado->num_rows === 0)
            {
                $existeUsuario = false;
            }else
            {
                $existeUsuario = true;
                $mensajeDeError += "El usuario ingresado ya existe<br>";
            }

            $consultaMail = "SELECT mail FROM USUARIOS where mail = '$mail' ";

            $resultado = $this->db->query($consultaMail) or die("Error en el SELECT mail: ".mysqli_error($this->db));

            if($resultado->num_rows === 0)
            {
                $existeMail = false;
            }else
            {
                $existeMail = true;
                $mensajeDeError += "El mail ingresado ya existe<br>";
            }


            if($existeMail == true || $existeUsuario == true)
            {
                //Informo.
                echo $mensajeDeError;
            }else
            {
                //Procedo a insertar los datos a la bdd.

                //Genero el id del usuario con md5.
                $id_usuario = md5($usuario);

                //Encripto la contraseña con md5
                $passEncript = md5($pass);


                $consulta = "INSERT INTO USUARIOS VALUES 
                ('$id_usuario',$numero_dni,'$tipo_dni','cliente','$nombre','$apellido','$usuario','$passEncript','$calle',$altura,'$depto','$partido','$provincia','$mail',$telefono,$celular)";

                $this->db->query($consulta) or die('Error en el INSERT: ' . mysqli_error($this->db));

                echo "Usuario registrado";

            }
        }
    }

    public function iniciarSesion(){
        $mailUsuario = $_REQUEST['mailUsuario'];
        $pass = $_REQUEST['pass'];
        $puedoIniciarSesion = false;

        //Verifico si mailUsuario es el mail o el usuario.
        if(preg_match("/^[a-zA-Z0-9_ñÑáéíóÁÉÍÓÚ]*[@]+[a-z]+([.]{1}[a-z]+)*$/",$mailUsuario))
        {
            //Es mail
            if(preg_match("/[\w]{6,}/",$pass))
            {
                $passEncript = md5($pass);
                $consulta = "SELECT nombre_usuario FROM USUARIOS where mail = '$mailUsuario' and pass = '$passEncript'";
                $resultado = $this->db->query($consulta) or die( "Error: ".mysqli_error($this->db) );

                if($resultado->num_rows === 1)
                {
                    $puedoIniciarSesion = true;
                };

            }else
            {
                echo "La contraseña ingresada no es válida.<br/>";
            }
        }else
        {
            if(preg_match("//",$mailUsuario))
            {
                //Es usuario
                if(preg_match("/[\w]{6,}/",$pass))
                {
                    $passEncript = md5($pass);
                    $consulta = "SELECT nombre_usuario FROM USUARIOS where nombre_usuario = '$mailUsuario' and pass = '$passEncript'";
                    $resultado = $this->db->query($consulta) or die( "Error en el SELECT: ".mysqli_error($this->db) );

                    if($resultado->num_rows === 1)
                    {
                        $puedoIniciarSesion = true;
                    };

                }else
                {
                    echo "La contraseña ingresada no es válida.<br/>";
                }
            }else
            {
               echo "El nombre de usuario o e-mail no es válido.<br/>";
            }
        }

        //Inicio session.
        if($puedoIniciarSesion)
        {
            session_start();

            $_SESSION['usuario'] = $mailUsuario;

            echo "Bienvenido ".$_SESSION['usuario'];
        }else
        {
            echo "Los datos ingresados no son correctos.<br/>";
        }

    }


    public function procesarDatosDomicilio($datos){

        $respuesta = array();
        $calle = $datos['calle'];
        $altura = $datos['altura'];
        $depto = $datos['depto'];
        
        if(preg_match("/^[0-9a-zA-ZñÑáéíóÁÉÍÓÚ ]*/",$calle))
        {
            $mensajeErrores["calle"] = 0;
        }else
        {
           $mensajeErrores["calle"] = "La calle ingresada no es válida"; 
        }

        if(preg_match("/[0-9]+/",$altura))
        {
            $mensajeErrores["altura"] = 0;
        }else
        {
           $mensajeErrores["altura"] = "La altura ingresada no es válida"; 
        }

        if(preg_match("/[0-9]+/",$depto))
        {
            $mensajeErrores["depto"] = 0;
        }else
        {
           $mensajeErrores["depto"] = "El número de departamento no es válido"; 
        } 

        //Verifico si hay errores.

        $hayError = false;
        $mensajeDeError = "";
        foreach($mensajeErrores as $error){

            if( $error !== 0 )
            {
                $hayError = true;
                $mensajeDeError = $mensajeDeError . $error."<br>";
            }
        }

        if($hayError)
        {
            //Guardo los mensajes de error en la variable respuesta
            $respuesta['mensaje'] = $mensajeDeError;
            $respuesta['datosCorrectos'] = false;

            echo json_encode($respuesta); 

        }else
        {
            //Si no hay error, devuelvo los datos del domicilio y digo que los datos son correctos:
            $respuesta['datosCorrectos'] =  true;
            $respuesta['datosDomicilio'] = array('calle'=> $calle, 'altura'=> $altura, 'depto'=> $depto);

            //Envio la respuesta con los datos a JS:
            //echo json_encode($repuesta);
            echo json_encode($respuesta);

        }

    }


    public function verificarSesionIniciada(){
        $sesionIniciada;
        
        if(!isset($_SESSION)){
            session_start();
        }

        if(isset($_SESSION['usuario'])){
            //Si existe una sesión sesionInicada será true.
            $sesionIniciada = true;
        }else
        {
            $sesionIniciada = false;
        }

        echo json_encode($sesionIniciada);
    }


    public function obtenerIdUsuario($usuario){

        $consulta = "select id_usuario from USUARIOS where nombre_usuario = '$usuario'";

        $registros = $this->db->query($consulta) or die("Error en la consulta obtenerIdUsuario: " . mysqli_error($this->db));

        while($objeto = $registros->fetch_object()){
            $id_usuario = $objeto->id_usuario;
        }

        return $id_usuario;
    }

    public function obtenerIdUltimoPedido(){

        $consulta = "SELECT MAX(id_pedido) FROM PEDIDOS";

        $registros = $this->db->query($consulta) or die( "Error en la consulta obtenerIdUltimoPedido: ".mysqli_error($this->db) );
    
        while($objeto = $registro->fetch_object()){
            $id_pedido = $objeto->id_pedido;
        }

        return $id_pedido;
    }

    public function generarFactura($datos){

    }

    public function generarComprobante($datos){

    }
}

?>