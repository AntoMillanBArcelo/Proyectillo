<?php
require_once '././helper/Validacion.php';
    $valida=new Validacion();
    if(isset($_POST['submit']))
    {
        $valida->Requerido('usuario');
        $valida->Requerido('contrasena');
        //Comprobamos validacion
        if($valida->ValidacionPasada())
        {
            if(Login::Identifica($_POST['usuario'],$_POST['contrasena'],
            isset($_POST['recuerdame'])?$_POST['recuerdame']:false))
            {
                $url=$_GET['returnurl'];
                header("location:?menu=".$url);
            }
        }
    }
?>
<div class='w-50 p-3 container'>
    <div class='login-form'>
        <form action='' method='post' novalidate>
            <h2 class='text-center'>Identificate</h2>
            <div class='form-group'>
                <input type='text' class='form-control' name='usuario' placeholder='Usuario' required='required'>
                <?= $valida->ImprimirError('usuario') ?>
            </div>
            <div class='form-group'>
                <input type='password' class='form-control' name='contrasena' placeholder='Contraseña'
                    required='required'>
                <?= $valida->ImprimirError('contrasena') ?>
            </div>
            <div class='form-group'>
                <button type='submit' name='submit' class='btn btn-primary btn-block'>Logueate</button>
            </div>
            <div class='clearfix'>
                <label class='pull-left checkbox-inline'>
                    <input type='checkbox' name='recuerdame'> Recuerdame</label>
            </div>
        </form>
        <p class='text-center'><a href='#'>Crear una Cuenta</a></p>
    </div>
</div> 

Uncaught Error: Class "Validacion" not found in C:\xampp\htdocs\ProyectoAutoescuela\Vistas\Login\autentifica.php:2 Stack trace: 
#0 C: \xampp\htdocs\ProyectoAutoescuela\Vistas\Principal\enruta.php(7): require_once() #1 
C:\xampp\htdocs\ProyectoAutoescuela\Vistas\Principal\layout.php(23): require_once('C:\\xampp\\htdocs...') 
#2 C:\xampp\htdocs\ProyectoAutoescuela\index.php(7): require_once('C:\\xampp\\htdocs...') #3 C:\xampp\htdocs\ProyectoAutoescuela\index.php(10): Principal::main() #4 
{main} thrown in C:\xampp\htdocs\ProyectoAutoescuela\Vistas\Login\autentifica.php on line 2