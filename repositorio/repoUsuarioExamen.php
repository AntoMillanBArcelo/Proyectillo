<?php

class repoUsuarioExamen
{
    
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getByUserId($userId)
    {
        $stmt = $this->con->prepare("SELECT * FROM usuario_examen WHERE id_usuario = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerIdUsuario() {
        
        if (isset($_SESSION['user']['id'])) 
        {
            return $_SESSION['user']['id'];
        } 
        else 
        {
            return false;
        }
    }

}
