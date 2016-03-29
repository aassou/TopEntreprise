<?php
class Sorties{

    //attributes
    private $_id;
    private $_dateOperation;
    private $_montant;
	private $_statut;
	private $_user;
	
    
    //le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d'une façon dynamique!
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
    
    //setters
    public function setId($id){
        $this->_id = $id;
    }
    
    public function setDateOperation($dateOperation){
        $this->_dateOperation = $dateOperation;
    }
    
    public function setMontant($montant){
        $this->_montant = $montant;
    }
    
	public function setStatut($statut){
        $this->_statut = $statut;
    }
	
	public function setUser($user){
        $this->_user = $user;
    }
	
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function dateOperation(){
        return $this->_dateOperation;
    }
    
    public function montant(){
        return $this->_montant;
    }
    
	public function statut(){
        return $this->_statut;
    }
	
	public function user(){
        return $this->_user;
    }
	    
}