<?= $this->extend('inicio') ?>
<?= $this->section('content') ?>
<script src ='css/echarts.js'></script>
<script src='css/comunicaciones.js'></script>
<link rel="stylesheet" type="text/css" href="css/comunicaciones.css">
<main id="conPrincipal" style="height: 53em; width:100%; border-radius:10px; margin-top:1%; padding: 0.5%">


    <!--zona con los estados de conexiones-->
    <!--su contenido es provisional-->
    <div id="displayComs">
        <table style="width:100%; height:100%">
            <tr onclick="graficoConex()" id='seccionEstacion'>
                <td id='secNombre'>
                    N Estacion
                </td>
                <td id='secEstado'>
                    <i class="fas fa-check"></i>
                </td>
                <td id='secUltima'>
                   Ultima Conexion
                </td>
            </tr>

            <tr onclick="graficoConex()" id='seccionEstacion'>
                <td id='secNombre'>
                    N Estacion
                </td>
                <td id='secEstado'>
                    <i class="fas fa-check"></i>
                </td>
                <td id='secUltima'>
                   Ultima Conexion
                </td>
            </tr>

            <tr onclick="graficoConex()" id="seccionEstacionProblema">
                <td id="secNombre">
                    N Estacion
                </td>

                <td id="secProblema">
                    <i class="fas fa-exclamation-triangle"></i>
                </td>

                <td id="secUltima">
                    Ultima Conexion
                </td>
            </tr>

            <tr onclick="graficoConex()"id="seccionEstacionError">
                <td id="secNombre">
                    N Estacion
                </td>

                <td id="secError">
                    <i class="fas fa-times-circle"></i>

                </td>

                <td id="secUltima">
                    Ultima Conexion
                </td>

            </tr>

            <tr onclick="graficoConex()" id='seccionEstacion'>
                <td id='secNombre'>
                    N Estacion
                </td>
                <td id='secEstado'>
                    <i class="fas fa-check"></i>
                </td>
                <td id='secUltima'>
                   Ultima Conexion
                </td>
            </tr>

            <tr onclick="graficoConex()" id="seccionEstacionProblema">
                <td id="secNombre">
                    N Estacion
                </td>

                <td id="secProblema">
                    <i class="fas fa-exclamation-triangle"></i>
                </td>

                <td id="secUltima">
                    Ultima Conexion
                </td>
            </tr>

        </table>
    </div>

    <!--sitio para el grafico de resumen del estado-->
    <div id="seccionDetalles1">
        <div id="graficoConexion" style="width: 720px; height:350px;"></div>
    </div>

    <!--sitio para mas informacion-->
    <div id="seccionDetalles2">
        detalles de la estacion seleccionada (?)
    </div>

</main>


<!--alarmas de abajo-->
<table id="alarmasSur">
</table>

<script>
    window.onload = function() {
        actualizarMini();
        graficoConex();
        setInterval(fechaYHora, 1000);
        setInterval(comprobarTiempo, 1000);
        setInterval(parpadeoProblema, 1000);
        setInterval(parpadeoError, 1000);
        setInterval(actualizarMini, 3000);
        $(window).blur(function() {
            tiempoFuera("");
        });
        $(window).focus(function() {
            tiempoFuera("volver")
        });
    }
</script>


<?= $this->endSection() ?>