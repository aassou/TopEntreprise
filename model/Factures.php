<?php
class Factures{

    //attributes
    private $_id;
    private $_chemin;
	private $_idCharge;
	private $_categorie;
	    
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

	public function setChemin($chemin){
		$this->_chemin = $chemin;
	}
	
	public function setIdCharge($idCharge){
		$this->_idCharge = $idCharge;
	}
	
	public function setCategorie($categorie){
		$this->_categorie = $categorie;
	}
    //getters
    
    public function id(){
        return $this->_id;
    }
    
	public function chemin(){
		return $this->_chemin;
	}
	
	public function idCharge(){
		return $this->_idCharge;
	}
	
	public function categorie(){
		return $this->_categorie;
	}
	    
}