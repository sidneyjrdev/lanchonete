<?php

require_once("Administrador.php");

class Destaque {
    
private $cod;
private $imagem;
private $dataExpiracao;
private $status_exibicao;
private $adm;
    
public function __construct(){
    $this->adm = new Administrador();
}

function getCod(){
    return $this->cod;
}

function getImagem(){
    return $this->imagem;
}

function getDataExpiracao(){
    return $this->dataExpiracao;
}

function getStatusExibicao(){
    return $this->status_exibicao;
}


function getAdministrador(){
    return $this->adm;
}

function setCod($cod){
    $this->cod = $cod;
}

function setImagem($imagem){
    $this->imagem = $imagem;
}

function setDataExpiracao($dataExpiracao){
    $this->dataExpiracao = $dataExpiracao;
}

function setStatusExibicao($status_exibicao){
    $this->status_exibicao = $status_exibicao;
}

function setAdministrador($adm){
    $this->adm = $adm;
}

}
