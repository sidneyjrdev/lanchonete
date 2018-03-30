<?php



class Administrador {
    
private $cod;
private $nome;
private $email;
private $senha;
private $foto;
private $administrador;
    

function getCod(){
    return $this->cod;
}

function getNome(){
    return $this->nome;
}

function getEmail(){
    return $this->email;
}

function getSenha(){
    return $this->senha;
}

function getFoto(){
    return $this->foto;
}

function getAdministrador(){
    return $this->administrador;
}

function setCod($cod){
    $this->cod = $cod;
}

function setNome($nome){
    $this->nome = $nome;
}

function setEmail($email){
    $this->email = $email;
}

function setSenha($senha){
    $this->senha = $senha;
}

function setFoto($foto){
    $this->foto = $foto;
}

function setAdministrador($administrador){
    $this->administrador = $administrador;
}

}
