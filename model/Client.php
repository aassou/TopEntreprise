<?php
class Client{

    //attributes
    private $_id;
    private $_nom;
	private $_cin;
    private $_numeroTelefon;
    
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
    
    public function setNom($nom){
        $this->_nom = $nom;
    }
	
	public function setCin($cin){
        $this->_cin = $cin;
    }
    
    public function setNumeroTelefon($numeroTelefon){
        $this->_numeroTelefon = $numeroTelefon;
    }
    
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function nom(){
        return $this->_nom;
    }
	
	public function cin(){
        return $this->_cin;
    }
    
    public function numeroTelefon(){
        return $this->_numeroTelefon;
    }
        
}