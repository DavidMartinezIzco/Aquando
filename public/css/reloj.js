

//configs para el codigo
    var tiempoMax = 15*60;  // 15 mins
    if(sessionStorage.getItem('tmax') !== null){
        tiempoMax = sessionStorage.getItem('tmax');
    }

    var tiempoStandBy = 0;
    document.onclick = function() {
        tiempoStandBy = 0;
    };
    document.onmousemove = function() {
        tiempoStandBy = 0;
    };


//muestra la hora del sistema
function fechaYHora() {
    var currentdate = new Date(); 
    var datetime = currentdate.getDate() + "/"
            + (currentdate.getMonth()+1)  + "/" 
            + currentdate.getFullYear() + " <br> "  
            + currentdate.getHours() + ":"  
            + currentdate.getMinutes() + ":" 
            + currentdate.getSeconds();
    document.getElementById('fechahora').innerHTML = datetime;
}

//comprueba el tiempo que lleva el cliente inactivo
function comprobarTiempo() {
if(document.getElementById("seccion").value != "login")
formatearTiempo(tiempoMax - tiempoStandBy);    
tiempoStandBy++;
    if (tiempoStandBy == tiempoMax) {
        window.location.href = "/Aquando/public/index.php?log=out";
    }
}

//da formato a la hora y la prepara para representarla
function formatearTiempo(segs) {
    
    var hours   = Math.floor(segs / 3600);
    var minutos = Math.floor((segs - (hours * 3600)) / 60);
    var segundos = segs - (hours * 3600) - (minutos * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutos < 10) {minutos = "0"+minutos;}
    if (segundos < 10) {segundos = "0"+segundos;}
    document.getElementById("restante").innerText =  minutos+':'+segundos;
}

//modifica el tiempo de inactividad para el cliente
function modificarInactividad(minutos){

    tiempoMax = minutos * 60;
    tiempoMax--;
    sessionStorage.setItem('tmax', tiempoMax);
    tiempoOpciones();

}