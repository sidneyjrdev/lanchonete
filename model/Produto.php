<?php
require_once 'Administrador.php';

class Produto {
    
private $cod;
private $nome;
private $tipo;
private $descricao;
private $preco;
private $slug;
private $data_ultima_modific;
private $imagem;
private $adm;
    
public function __construct(){
    $this->adm = new Administrador();
}
    
function getCod() {
    return $this->cod;
}

function getNome() {
    return $this->nome;
}

function getTipo() {
    return $this->tipo;
}

function getDescricao() {
    return $this->descricao;
}

function getPreco() {
    return $this->preco;
}

function getSlug() {
    return $this->slug;
}

function getDataUltimaModific() {
    return $this->data_ultima_modific;
}

function getImagem() {
    return $this->imagem;
}

function getAdministrador() {
    return $this->adm;
}

function setCod($cod) {
    $this->cod = $cod;
}

function setNome($nome) {
    $this->nome = $nome;
}

function setTipo($tipo) {
    $this->tipo = $tipo;
}

function setDescricao($descricao) {
    $this->descricao = $descricao;
}

function setPreco($preco) {
    $this->preco = $preco;
}

function setSlug($slug) {
    $this->slug = $slug;
}

function setDataUltimaModific($data_ultima_modific) {
    $this->data_ultima_modific = $data_ultima_modific;
}

function setImagem($imagem) {
    $this->imagem = $imagem;
}

function setAdministrador($adm) {
    $this->adm = $adm;
}




}

