<?php

if(isset($_SESSION['cod'])){
require_once '../DAL/AdministradorDAO.php';}
else {
require_once 'DAL/AdministradorDAO.php';} 

class AdministradorController {

    private $admDAO;
    
    public function __construct() {
        $this->admDAO = new AdministradorDAO();
    }

    public function pegarAdmLogin($email, $senha) {
      if(strpos($email, "@") && strpos($email, ".") && strlen($senha) > 5){
        $senha = md5($senha);
        return $this->admDAO->pegarAdmLogin($email, $senha);  
      }else{
        return null; 
      }
    }
      
    public function cadastrarAdm($adm){
       if(strpos($adm->getEmail(), "@") && strpos($adm->getEmail(), ".") && strlen($adm->getSenha()) > 5 && 
          strlen($adm->getNome()) > 2 && $adm->getFoto() != "invalid"){
           
           return $this->admDAO->cadastrarAdm($adm);
       }else{
           
           return false;
       }
    }
      
    public function pegarListaEmails(){
        
            $listaEmails = [];
            $listaEmails = $this->admDAO->pegarListaEmails();
            return $listaEmails;
        
    }
    
    public function pegarAdmCod($cod) {
        if($cod > 0){
            return $this->admDAO->pegarAdmCod($cod);
        }else{
            return null;
        }
    }
        
    public function editarAdm($adm, $atualizaImg) {
        if(strpos($adm->getEmail(), "@") && strpos($adm->getEmail(), ".") && 
          strlen($adm->getNome()) > 2 && $adm->getFoto() != "invalid"){
           
           return $this->admDAO->editarAdm($adm, $atualizaImg);
       }else{
           
           return false;
       }
    }
    
    public function excluirAdm($cod) {
        if($cod > 0){
            return $this->admDAO->excluirAdm($cod);
        }else{
            return false;
        }
    }
    
    public function mudarSenha($cod, $senha) {
        if($cod > 0 && strlen($senha) > 5){
            return $this->admDAO->mudarSenha($cod, $senha);
        }else{
            return false;
        }
    }
    
    
    }
