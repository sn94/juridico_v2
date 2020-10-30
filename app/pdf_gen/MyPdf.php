<?php

namespace App\pdf_gen;
use PDF;

private function monthDescr($m){
    $r="";
    switch( $m){
        case 1: return "Enero";break;
        case 2: return "Febrero";break;
        case 3: return "Marzo";break;
        case 4: return "Abril";break;
        case 5: return "Mayo";break;
        case 6: return "Junio";break;
        case 7: return "Julio";break;
        case 8: return "Agosto";break;
        case 9: return "Septiembre";break;
        case 10: return "Octubre";break;
        case 11: return "Noviembre";break;
        case 12: return "Diciembre";break;
    }  return $r;
}



public function generarPdf( $DATO){ 


    $html=<<<EOF
    <style>
    table.cabecera{
        font-size:11px;  
    }
    span{
        font-weight: bolder;
    }
    table.tabla{
        color: #003300;
        font-family: helvetica;
        font-size: 8pt;
        border-left: 3px solid #777777;
        border-right: 3px solid #777777;
        border-top: 3px solid #777777;
        border-bottom: 3px solid #777777;
        background-color: #ddddff;
    }
    
    tr.header{
        background-color: #ccccff; 
        font-weight: bold;
    } 
    tr{
        background-color: #ddeeff;
        border-bottom: 1px solid #000000; 
    }
    tr.success{
        background-color: #aaffaa;
        border-bottom: 1px solid #000000; 
    }
    tr.pending{
        background-color: #888888;
        border-bottom: 1px solid #000000; 
    }
    tr.danger{
        background-color: #ffaaaaa;
        border-bottom: 1px solid #000000; 
    }
    </style>
    <table class="cabecera">
    <tbody>
    <tr> <td> </td> <td> </td> <td> </td> </tr>
    </tbody>
    </table>
    <h6></h6>
    <table class="tabla">
    <thead >
    <tr class="header">
    <td>Cedula</td>
    <td>Nombre completo</td>
    <td>Telefono</td>
    <td>Importe aprobado</td>
    <td>Vendedor</td>
    <td>Estado</td>
    <td>Empresa</td>
    </tr>
    </thead>
    <tbody>
    EOF;
    foreach( $DATO as $row){
        $nombres= $row->nombres." ".$row->apellidos;
        $estado= ($row->estado =="P" )? "PENDIENTE": ($row->estado =="A" ? "APROBADO":"RECHAZADO") ;
        $clase= ($row->estado =="P" )? "pending": ($row->estado =="A" ? "success":"danger") ;
        $html.="<tr class='$clase'> <td>{$row->cedula}</td> <td>{$nombres}</td> <td>{$row->telefono},{$row->celular}</td> <td>{$row->monto_a}</td><td>{$row->vendedor}</td> <td>{$estado}</td><td>{$row->empresa}</td></tr>";
    }
    $html.="</tbody> </table> ";
    /********* */

    $tituloDocumento= "Clientes-".date("d")."-".date("m")."-".date("yy")."-".rand();

       // $this->load->library("PDF"); 	
        $pdf = new PDF(); 
        $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
        $pdf->generarHtml( $html);
        $pdf->generar();
}




?>