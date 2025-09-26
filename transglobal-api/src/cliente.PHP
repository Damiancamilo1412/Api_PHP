<?php
namespace App;

class Cliente {
    public $id;
    public $nombre;
    public $correo;

    public function __construct($id, $nombre, $correo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
    }
}
