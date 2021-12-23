<?php
class Database
{
    private $host = "172.16.3.2";
    private $dbname = "Aquando";
    private $user = "postgres";
    private $password = "123456";
    private $conexion;


    public function __construct(){
    }

    private function conectar(){
        return $this->conexion = pg_connect("host=$this->host dbname=$this->dbname user=$this->user password=$this->password");
    }

    public function obtenerIdUsuario($nombre, $pwd, $id_cliente){
        if ($this->conectar()) {
            $consulta = "SELECT id_usuario FROM usuarios WHERE nombre ='$nombre' AND password ='$pwd' AND id_cliente = ".$id_cliente."";
            $resultado = pg_query($this->conexion, $consulta);
            if ($this->consultaExitosa($resultado)) {
                $id_usu = pg_fetch_all($resultado);
                return $id_usu;
            } else {
                return false;
            }
        }
    }

    function consultaExitosa($resultado){
        $nResuls = pg_num_rows($resultado);
        if ($nResuls != 0 || $nResuls != null) {
            return true;
        } else {
            return false;
        }
    }

    public function existeUsuario($nombre, $pwd, $id_cliente){
        if ($this->conectar()) {
            $consulta = "SELECT * FROM public.usuarios WHERE nombre ='$nombre' AND password ='$pwd' AND id_cliente = '$id_cliente'";
            $resultado = pg_query($this->conexion, $consulta);
            if ($this->consultaExitosa($resultado)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function mostrarEstacionesCliente($nombre, $pwd){
        if($this->conectar()){
            $consulta = "SELECT estaciones.nombre_estacion, estaciones.id_estacion FROM usuarios INNER JOIN usuario_estacion ON usuarios.id_usuario = usuario_estacion.id_usuario INNER JOIN estaciones ON usuario_estacion.id_estacion = estaciones.id_estacion WHERE usuarios.nombre ='$nombre' AND usuarios.password ='$pwd'";
            $resultado = pg_query($this->conexion, $consulta);
            if ($this->consultaExitosa($resultado)) {
                $estacionesArr = pg_fetch_all($resultado);
                return $estacionesArr;
            } else {
                return false;
            }
        }
    }

    public function obtenerAlarmasUsuario($id_usuario, $orden, $sentido){
        if($this->conectar()){
            
            $prioridad = 'alarmas.fecha_origen';
            if($orden != null){
                $prioridad = 'alarmas.fecha_origen';
            if($orden != null){
                $prioridad = null;
                switch ($orden) {
                    case 'estado':
                        $prioridad = 'alarmas.estado';
                        break;
                    case 'senal':
                        $prioridad = 'tags.nombre_tag';
                        break;
                    case 'restauracionfecha':
                        $prioridad = 'alarmas.fecha_restauracion';
                        break;
                    case 'estacion':
                        $prioridad = 'estaciones.nombre_estacion';
                        break;
                    case 'reconfecha':
                        $prioridad = 'alarmas.fecha_ack';
                        break;
                    case 'reconusu':
                        $prioridad = 'alarmas.ack_por';
                        break;
                    case 'valor':
                        $prioridad = 'alarmas.valor_alarma';
                        break;
                    case 'origenfecha':
                        $prioridad = 'alarmas.fecha_origen';
                        break;
                    
                    default:
                    $prioridad = 'alarmas.fecha_origen';
                        break;
                }
            }
            }

            $conAlarmas = "SELECT 
                estaciones.nombre_estacion, tags.nombre_tag, alarmas.id_alarmas, alarmas.valor_alarma, alarmas.fecha_origen, alarmas.fecha_restauracion, alarmas.estado, alarmas.ack_por, alarmas.fecha_ack 
                FROM alarmas INNER JOIN estacion_tag ON alarmas.id_tag = estacion_tag.id_tag INNER JOIN usuario_estacion ON usuario_estacion.id_estacion = estacion_tag.id_estacion INNER JOIN estaciones ON estaciones.id_estacion = estacion_tag.id_estacion INNER JOIN tags ON alarmas.id_tag = tags.id_tag
                WHERE usuario_estacion.id_usuario = ".$id_usuario[0]['id_usuario']." ORDER BY $prioridad DESC";

             if($sentido != null){
                 if($sentido == 'ASC'){
                    $conAlarmas = "SELECT 
                    estaciones.nombre_estacion, tags.nombre_tag, alarmas.id_alarmas, alarmas.valor_alarma, alarmas.fecha_origen, alarmas.fecha_restauracion, alarmas.estado, alarmas.ack_por, alarmas.fecha_ack 
                    FROM alarmas INNER JOIN estacion_tag ON alarmas.id_tag = estacion_tag.id_tag INNER JOIN usuario_estacion ON usuario_estacion.id_estacion = estacion_tag.id_estacion INNER JOIN estaciones ON estaciones.id_estacion = estacion_tag.id_estacion INNER JOIN tags ON alarmas.id_tag = tags.id_tag
                    WHERE usuario_estacion.id_usuario = ".$id_usuario[0]['id_usuario']." ORDER BY $prioridad ASC";
                 }
             }

            $resulAlarmas = pg_query($conAlarmas);
            if($this->consultaExitosa($resulAlarmas)){
                $alarmas = pg_fetch_all($resulAlarmas);
                return $alarmas;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function obtenerAlarmasEstacion($id_estacion,$orden,$sentido, $fechaInicio, $fechaFin){
        if($fechaInicio != null){
            //traducir fecha
        }
        if($fechaFin != null){
            //traducir fecha
        }

        $prioridad = 'alarmas.fecha_origen';
            if($orden != null){
                $prioridad = null;
                switch ($orden) {
                    case 'estado':
                        $prioridad = 'alarmas.estado';
                        break;
                    case 'senal':
                        $prioridad = 'tags.nombre_tag';
                        break;
                    case 'restauracionfecha':
                        $prioridad = 'alarmas.fecha_restauracion';
                        break;
                    case 'estacion':
                        $prioridad = 'estaciones.nombre_estacion';
                        break;
                    case 'reconfecha':
                        $prioridad = 'alarmas.fecha_ack';
                        break;
                    case 'reconusu':
                        $prioridad = 'alarmas.ack_por';
                        break;
                    case 'valor':
                        $prioridad = 'alarmas.valor_alarma';
                        break;
                    case 'origenfecha':
                        $prioridad = 'alarmas.fecha_origen';
                        break;
                    
                    default:
                    $prioridad = 'alarmas.fecha_origen';
                        break;
                }
            }

        if ($this->conectar()) {

            $consulta = "SELECT estaciones.nombre_estacion, tags.nombre_tag, alarmas.id_alarmas, alarmas.valor_alarma, alarmas.fecha_origen, alarmas.fecha_restauracion, alarmas.estado, alarmas.ack_por, alarmas.fecha_ack 
            FROM alarmas INNER JOIN estacion_tag ON alarmas.id_tag = estacion_tag.id_tag INNER JOIN usuario_estacion ON usuario_estacion.id_estacion = estacion_tag.id_estacion INNER JOIN estaciones ON estaciones.id_estacion = estacion_tag.id_estacion INNER JOIN tags ON alarmas.id_tag = tags.id_tag
            WHERE estacion_tag.id_estacion = '$id_estacion' ORDER BY $prioridad DESC";
            if($sentido != null){
                if($sentido == 'ASC'){
                    $consulta = "SELECT estaciones.nombre_estacion, tags.nombre_tag, alarmas.id_alarmas, alarmas.valor_alarma, alarmas.fecha_origen, alarmas.fecha_restauracion, alarmas.estado, alarmas.ack_por, alarmas.fecha_ack 
                    FROM alarmas INNER JOIN estacion_tag ON alarmas.id_tag = estacion_tag.id_tag INNER JOIN usuario_estacion ON usuario_estacion.id_estacion = estacion_tag.id_estacion INNER JOIN estaciones ON estaciones.id_estacion = estacion_tag.id_estacion INNER JOIN tags ON alarmas.id_tag = tags.id_tag
                    WHERE estacion_tag.id_estacion = '$id_estacion' ORDER BY $prioridad ASC";
                }
            }
            
            $resultado = pg_query($this->conexion, $consulta);


            if ($this->consultaExitosa($resultado)) {
                $alarmasEstacion = pg_fetch_all($resultado);
                return $alarmasEstacion;
            }
        } else {
            return false;
        }
    }

    public function datosEstacion($id_estacion){

        if($this->conectar()){
                $ultimaFecha = "SELECT MAX(fecha) FROM datos";

                $consulta = "SELECT DISTINCT
                tags.nombre_tag,
                datos.fecha,
                datos.calidad,
                datos.valor_bool,
                datos.valor_int,
                datos.valor_float,
                datos.valor_acu,
                datos.valor_date
            FROM 
            datos INNER JOIN tags ON datos.id_tag = tags.id_tag
            INNER JOIN estacion_tag ON estacion_tag.id_tag = tags.id_tag
            WHERE estacion_tag.id_estacion = '$id_estacion' AND datos.fecha = ($ultimaFecha)
            ORDER BY tags.nombre_tag
            LIMIT 10
            ";
            $resultado = pg_query($this->conexion, $consulta);
            if($this->consultaExitosa($resultado)){
                $datosEstacion = pg_fetch_all($resultado);
                return $datosEstacion;
            }
            else {
                return "error";
            }
        }
    }

    public function tagsEstacion($id_estacion){
        if($this->conectar()){
            $conTags = "SELECT tags.id_tag, tags.nombre_tag FROM estacion_tag INNER JOIN tags ON tags.id_tag = estacion_tag.id_tag WHERE estacion_tag.id_estacion = $id_estacion AND tags.historizar = true";
            $resulTags = pg_query($this->conexion, $conTags);
            if($this->consultaExitosa($resulTags)){
                $tagsEstacion = pg_fetch_all($resulTags);

                $_SESSION['tagsEstacion'] = $tagsEstacion;
                return $tagsEstacion;
            }
            else {
                return false;
            }
            return false;
        }
    }

    //para las fechas vamos a necesitar un traductor de Date() a TimeStamp()
    public function historicosEstacion($id_estacion, $fechaIni, $fechaFin){
        if($this->conectar()){

            $tagsEstacion = $this->tagsEstacion($id_estacion);
            $_SESSION['tagsEstacion'] = $tagsEstacion;
            if($tagsEstacion != false){

                foreach ($tagsEstacion as $index => $tag) {
                    if($tag['id_tag'] != 1){
                        $conHisto = "SELECT fecha, calidad, valor_bool, valor_int, valor_acu, valor_float, valor_string, valor_date FROM datos_historicos WHERE id_tag = ".$tag['id_tag']." ";
                        if($fechaIni != ""){
                            $conHisto .= " AND fecha >= $fechaIni ";
                        }
                        if($fechaFin != ""){
                            $conHisto .=  " AND fecha <= $fechaFin ";
                        }
                        $conHisto .= " ORDER BY fecha DESC LIMIT 100";

                        $resulHisto = pg_query($this->conexion, $conHisto);
                        if($this->consultaExitosa($resulHisto)){
                            $historicoTag = pg_fetch_all($resulHisto);
                            $historicos[$tag['nombre_tag']] = $historicoTag;                
                        }
                    }   
                }
                return $historicos;
            }
        }
        else{
            return false;
        }
    }

    public function historicosTagEstacion($id_estacion, $id_tag){
        if($this->conectar()){
            $conHistoTagEst = "SELECT datos_historicos.fecha, datos_historicos.calidad, datos_historicos.valor_bool, datos_historicos.valor_int, datos_historicos.valor_acu, datos_historicos.valor_float, datos_historicos.valor_string, datos_historicos.valor_date FROM datos_historicos INNER JOIN estacion_tag ON estacion_tag.id_tag = datos_historicos.id_tag WHERE estacion_tag.id_tag = ".$id_tag." AND estacion_tag.id_estacion = ".$id_estacion." ORDER BY datos_historicos.fecha DESC";
            $resulHistoTagEst = pg_query($this->conexion, $conHistoTagEst);
            if($this->consultaExitosa($resulHistoTagEst)){
                $datosHistoTagEst = pg_fetch_all($resulHistoTagEst);
                $datosHisto = array();
                foreach ($datosHistoTagEst as $index => $dato) {
                    foreach ($dato as $factor => $valor) {
                        if($valor != null){
                            $datosHisto[$index][$factor] = $valor;
                        }
                    }
                   
                }
                return $datosHisto;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function reconocerAlarma($id_alarma, $usuario, $hora){

        if($this->conectar()){
            $conDatosAlarma = "SELECT estado FROM alarmas WHERE id_alarmas = $id_alarma";
            $resulDatosAlarma = pg_query($this->conexion, $conDatosAlarma);
            if($this->consultaExitosa($resulDatosAlarma)){
                $datosAlarma = pg_fetch_all($resulDatosAlarma);
                $estadoAlarma = $datosAlarma[0]['estado'];

                if($estadoAlarma == "1"){
                    $nuevoEstado = 3;
                }
                if ($estadoAlarma == "2") {
                    $nuevoEstado = 4;
                }

                $secuencia = "UPDATE alarmas SET estado = $nuevoEstado, ack_por = '$usuario', fecha_ack = '$hora' WHERE id_alarmas = $id_alarma";
                $resultado = pg_query($this->conexion, $secuencia);
                if($this->consultaExitosa($resultado)){
                    return true;
                }
            }
            else {
                return false;
            }
        }   
        else {
            return false;
        }

    }

    public function alarmasSur($id_usuario){
        if($this->conectar()){
            $conAlarmas = "SELECT estaciones.nombre_estacion, tags.nombre_tag, alarmas.id_alarmas, alarmas.valor_alarma, alarmas.fecha_origen, alarmas.fecha_restauracion, alarmas.estado, alarmas.ack_por, alarmas.fecha_ack 
            FROM alarmas INNER JOIN estacion_tag ON alarmas.id_tag = estacion_tag.id_tag INNER JOIN usuario_estacion ON usuario_estacion.id_estacion = estacion_tag.id_estacion INNER JOIN estaciones ON estaciones.id_estacion = estacion_tag.id_estacion INNER JOIN tags ON alarmas.id_tag = tags.id_tag
            WHERE usuario_estacion.id_usuario = ".$id_usuario[0]['id_usuario']." ORDER BY alarmas.fecha_origen DESC limit 7";

            $resulAlarmas = pg_query($conAlarmas);
            if($this->consultaExitosa($resulAlarmas)){
                $alarmas = pg_fetch_all($resulAlarmas);
                return $alarmas;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function alarmasEstacionSur($id_estacion){
        if ($this->conectar()) {
            $consulta = "SELECT estaciones.nombre_estacion, tags.nombre_tag, alarmas.id_alarmas, alarmas.valor_alarma, alarmas.fecha_origen, alarmas.fecha_restauracion, alarmas.estado, alarmas.ack_por, alarmas.fecha_ack 
            FROM alarmas INNER JOIN estacion_tag ON alarmas.id_tag = estacion_tag.id_tag INNER JOIN usuario_estacion ON usuario_estacion.id_estacion = estacion_tag.id_estacion INNER JOIN estaciones ON estaciones.id_estacion = estacion_tag.id_estacion INNER JOIN tags ON alarmas.id_tag = tags.id_tag
            WHERE estacion_tag.id_estacion = '$id_estacion' ORDER BY alarmas.fecha_origen DESC LIMIT 7";
            $resultado = pg_query($this->conexion, $consulta);
            if ($this->consultaExitosa($resultado)) {
                $alarmasEstacion = pg_fetch_all($resultado);
                return $alarmasEstacion;
            }
        } else {
            return false;
        }
    }

    //secuencia para sacar las ultimas conexiones de las estaciones
    //SELECT estaciones.nombre_estacion, datos_valores.valor_date, tags.nombre_tag FROM estaciones INNER JOIN estacion_tag ON estaciones.id_estacion = estacion_tag.id_estacion INNER JOIN tags ON tags.id_tag = estacion_tag.id_tag INNER JOIN datos_valores ON estacion_tag.id_tag = datos_valores.id_tag WHERE tags.nombre_tag LIKE 'Ultima Comunicacion%' ORDER BY estaciones.nombre_estacion DESC

    public function ultimaComunicacionEstacion($id_estacion){
        if($this->conectar()){
            $consulta = "SELECT estaciones.nombre_estacion, datos_valores.valor_date, tags.nombre_tag FROM estaciones INNER JOIN estacion_tag ON estaciones.id_estacion = estacion_tag.id_estacion INNER JOIN tags ON tags.id_tag = estacion_tag.id_tag INNER JOIN datos_valores ON estacion_tag.id_tag = datos_valores.id_tag WHERE tags.nombre_tag LIKE 'Ultima Comunicacion%' AND estaciones.id_estacion = ".$id_estacion." ORDER BY estaciones.nombre_estacion DESC";
            $resultado = pg_query($this->conexion, $consulta);
            if($this->consultaExitosa($resultado)){
                $ultimaConexion = pg_fetch_all($resultado);
                return $ultimaConexion;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}
