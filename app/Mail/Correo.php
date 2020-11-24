<?php 


namespace App\Mail;


class Correo{



    public $titulo="";
    public $remitente="";
    public $destinatario="";
    public $mensaje="";


    public function __construct(  )
    {
        
    }

    public function setTitulo( $ti){ $this->titulo= $ti;}
    public function setDestinatario( $ti){ $this->destinatario= $ti;}
    public function setRemitente($re){  $this->remitente=  $re; }
    public function setMensaje( $ti){ $this->mensaje= $ti;}

    public function getTitulo(  ){   return $this->titulo; }
    public function getDestinatario(  ){   return $this->destinatario; }
    public function getRemitente(){  return  $this->remitente; }
    public function getMensaje(  ){   return $this->mensaje; }




}
?>