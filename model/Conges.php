<?php
class Conges{

    //attributes
    private $_id;
    private $_nom;
	private $_dateDebut;
	private $_dateFin;
	
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
	
	public function setDateDebut($dateDebut){
		$this->_dateDebut = $dateDebut;
	}
	
	public function setDateFin($dateFin){
		$this->_dateFin = $dateFin;
	}
	
    //getters
    
    public function id(){
        return $this->_id;
    }
    
	public function nom(){
		return $this->_nom;
	}
	
	public function dateDebut(){
		return $this->_dateDebut;
	}
	
	public function dateFin(){
		return $this->_dateFin;
	}
	    
}