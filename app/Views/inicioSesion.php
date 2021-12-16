<?= $this->extend('inicio') ?>

<?= $this->section('content') ?>


<?php
 if(isset($_GET['log'])){
  echo '<script language="javascript">';
  echo 'alert("Su sesión a caducado");';
  echo '</script>';
 }
?>

<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">
<link href="/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">


<main class="form-signin" style="padding: 4em; width:100%;">
<img id="logoGrande" src="../public/logo.png">

  <form method="POST" id="formulario" >  
    <h1 class="h3 mb-3 fw-normal" style="color: white;">Inicio de sesión</h1>
    <div class="form-floating" style="margin-bottom: 15px;">
      <select class="form-control">
        <option>Empresa 1</option>
        <option>Empresa 2</option>
        <option>Empresa 3</option>
        <option>Empresa X</option>
      </select>
      <label for="floatingInput"style="color:black">Empresa</label>
    </div>
    <div class="form-floating" style="margin-bottom: 15px;">
      <input type="text" name="txtNombre" class="form-control">
      <label for="floatingInput"style="color:black">Usuario</label>
    </div>
    <div class="form-floating" style="margin-bottom: 15px;">
      <input type="password" name="txtContrasena" class="form-control">
      <label for="floatingPassword"style="color:black">Contraseña</label>
    </div>
    
    <button id="btnForm" class="w-100 btn btn-lg " style="background-color: rgb(56, 56, 56);margin-bottom: 100em; opacity:100%; color: white" type="submit">Iniciar Sesión</button>
  </form>
</main>



<?= $this->endSection() ?>