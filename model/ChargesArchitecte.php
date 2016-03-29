<?php
class ChargesArchitecte{

    //attributes
    private $_id;
    private $_nom;
	private $_montant;
	private $_dateCharges;
	private $_paye;
	private $_idProjet;
	
    
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
	
	public function setMontant($montant){
		$this->_montant = $montant;
	}
	
	public function setDateCharges($dateCharges){
		$this->_dateCharges = $dateCharges;
	}
	
	public function setPaye($paye){
		$this->_paye = $paye;
	}
	
	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
	}
	
	//getters
    public function id(){
        return $this->_id;
    }
    
	public function nom(){
		return $this->_nom;
	}
	
	public function montant(){
		return $this->_montant;
	}
	
	public function dateCharges(){
		return $this->_dateCharges;
	}
	
	public function paye(){
		return $this->_paye;
	}
	
	public function idProjet(){
		return $this->_idProjet;
	}
	    
}