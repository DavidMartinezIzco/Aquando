<?php

namespace App\Controllers;


require(APPPATH . "Models/Usuario.php");



use Usuario;


class Inicio extends BaseController
{
    private $usuario;
    private $sesion;

    public function __construct()
    {
        $this->sesion = \Config\Services::session();
        $this->sesion->start();
    }

    //ejecución de arranque del proyecto
    public function index(){
        if (isset($_GET['log']) && $_GET['log'] == 'out') {
            $_SESSION['seccion'] = "login";
            return $this->inicioSesion();
        } else {
            $_SESSION['seccion'] = "inicio";
            if (isset($_SESSION['nombre'])) {
                $this->usuario = new Usuario($_SESSION['nombre'], $_SESSION['pwd'], $_SESSION['empresa']);
                $_SESSION['estaciones'] = $this->usuario->obetenerEstacionesUsuario();
               
                return view('principal');
            } else {
                return view('inicio');
            }
        }
    }

    //inicia sesion usando las credenciales de zeus
    //habrá que cambiar este sistema en el futuro
    public function inicioSesion()
    {
        $_SESSION['seccion'] = "login";
        if (isset($_SESSION['nombre'])) {
            session_unset();
        }
        
        $nombre = "";
        $pwd = "";
        

        if(isset($_POST["txtNombre"]) && isset($_POST["txtContrasena"])){
                $nombre = $_POST["txtNombre"];
                $pwd = $_POST["txtContrasena"];
                $id = $_POST['selEmpresa'];

                $this->usuario = new Usuario($nombre, $pwd, $id);
                if($this->usuario->existeUsuario() == false){
                    echo '<script language="javascript">';
                    echo 'alert("Datos Incorrectos")';
                    echo '</script>';
                    return view('inicioSesion');
                }

                if($this->usuario->existeUsuario() == true) {
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['pwd'] = $pwd;

                    switch ($this->usuario->getCliente()) {
                        case 1:
                            $_SESSION['empresa'] = "Iturri Ederra";
                            break;
                        case 2:
                            $_SESSION['empresa'] = "Amescoa Alta";
                            break;
                        case 3:
                            $_SESSION['empresa'] = "Amescoa Baja";
                            break;
                        case 5:
                            $_SESSION['empresa'] = "Dateando";
                            break;
                        default:
                        $_SESSION['empresa'] = "Desconocida";
                            break;
                    }

                    $this->usuario->obetenerEstacionesUsuario();
                    return $this->index();
                }
                else {
                    echo '<script language="javascript">alert("Fallo la conexion")</script>';
                    return view('inicioSesion');
                }

        }
        else {
            return view('inicioSesion');
        }



    }

    //caca
    public function cafe()
    {
        return view('café');
    }


    //muestra la vista de las estaciones
    public function estacion()
    {
        //falta: cambiar a nueva BD
        if (isset($_SESSION['nombre'])) {
            $_SESSION['seccion'] = "estacion";
            return view('estacion');
        } else {
            return view('inicio');
        }
    }

    //muestra la vista de graficas (historicos y demas)
    public function graficas()
    {
        //falta: cambiar a nueva BD
        if (isset($_SESSION['nombre'])) {
            $_SESSION['seccion'] = "graficos";


            //estructura de datos para graficas
            //se conseguiran con consultas
            //necesitaremos otro con las fechas 
            //otro distinto para historicos + ajax
            $datosF = array(
                "info 1" => array(320, 332, 301, 334, 390, 330, 320),
                "info 2" => array(120, 132, 101, 134, 90, 230, 210),
                "info 3" => array(220, 182, 191, 234, 290, 330, 310),
                "info 4" => array(150, 232, 201, 154, 190, 330, 410),
                "info 5" => array(862, 1018, 964, 1026, 1679, 1600, 1570),
                "info 6" => array(620, 732, 701, 734, 1090, 1130, 1120),
                "info 7" => array(120, 132, 101, 134, 290, 230, 220),
                "info 8" => array(60, 72, 71, 74, 190, 130, 110),
                "info 9" => array(62, 82, 91, 84, 109, 110, 120)
            );

            $datos['datosF'] = $datosF;

            return view('graficas', $datos);
        } else {
            return view('inicio');
        }
    }

    // //muestra la zona principal de alarmas
    // public function alarmas()
    // {

    //     if (isset($_SESSION['nombre'])) {
    //         $_SESSION['seccion'] = "alarmas";
    //         if (isset($_SESSION['alarmas'])) {
    //             $datos['alarmas'] = $_SESSION['alarmas'];
    //         } else {
    //             //falta: cambiar a nueva BD
    //             $this->usuario = new Usuario($_SESSION['nombre'], $_SESSION['pwd'], $_SESSION['acc'], $_SESSION['pass']);
    //             //formato fecha: aaaa-mm-dd hh:mm:ss.000
    //             //alarmas desde principio de año
    //             $alarmas = $this->usuario->conseguirAlarmas(null, null, "2021-01-01 00:00:01.000");
    //             $datos['alarmas'] = $alarmas;
    //         }

    //         return view('alarmas', $datos);
    //     } else {
    //         return view('inicio');
    //     }
    // }

    //muestra la zona de informes
    public function informes()
    {
        if (isset($_SESSION['nombre'])) {
            $_SESSION['seccion'] = "infos";
            return view('informes');
        } else {
            return $this->inicioSesion();
        }
    }

    //muestra el estado de las conexiones con las estaciones
    public function comunicaciones()
    {
        //falta: cambiar a nueva BD
        $_SESSION['seccion'] = "coms";
        if (isset($_SESSION['nombre'])) {
        } else {
            return view('inicio');
        }
    }
}
