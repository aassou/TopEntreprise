<?php
class Charges{

    //attributes
    private $_id;
    private $_eau;
	private $_electricite;
	private $_fixe;
	private $_portable;
	private $_internet;
	private $_loyer;
	private $_dateCharges;
	
    
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

	public function setEau($eau){
		$this->_eau = $eau;
	}
	
	public function setElectricite($electricite){
		$this->_electricite = $electricite;
	}
	
	public function setFixe($fixe){
		$this->_fixe = $fixe;
	}
	
	public function setPortable($portable){
		$this->_portable = $portable;
	}
	
	public function setInternet($internet){
		$this->_internet = $internet;
	}
	
	public function setLoyer($loyer){
		$this->_loyer = $loyer;
	}
	
	public function setDateCharges($dateCharges){
		$this->_dateCharges = $dateCharges;
	}
	
    //getters
    
    public function id(){
        return $this->_id;
    }
    
	public function eau(){
		return $this->_eau;
	}
	
	public function electricite(){
		return $this->_electricite;
	}
	
	public function fixe(){
		return $this->_fixe;
	}
	
	public function portable(){
		return $this->_portable;
	}
	
	public function internet(){
		return $this->_internet;
	}
	
	public function loyer(){
		return $this->_loyer;
	}
	
	public function dateCharges(){
		return $this->_dateCharges;
	}
	    
}