<?php
class RendezVous{
    //attributes
    private $_id;
	private $_nomClient;
	private $_cin;
	private $_telefonClient;
	private $_source;
	private $_telefonSource;
    private $_dateRdv;
	private $_heureRdv;
    private $_nature;
	private $_prix;
	private $_mandataire;
	private $_statut;
	private $_province;
	private $_mp;
	private $_cr;
	private $_quartier;
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
	
	public function setNomClient($nomClient){
        $this->_nomClient = $nomClient;
    }
	
	public function setCin($cin){
        $this->_cin = $cin;
    }
	
	public function setTelefonClient($telefonClient){
        $this->_telefonClient = $telefonClient;
    }
	
	public function setSource($source){
        $this->_source = $source;
    }
	
	public function setTelefonSource($telefonSource){
        $this->_telefonSource = $telefonSource;
    }
	
	public function setDateRdv($dateRdv){
        $this->_dateRdv = $dateRdv;
    }
	
	public function setHeureRdv($heureRdv){
        $this->_heureRdv = $heureRdv;
    }
	
	public function setNature($nature){
        $this->_nature = $nature;
    }
	
	public function setPrix($prix){
		$this->_prix = $prix;
	}
	
	public function setMandataire($mandataire){
        $this->_mandataire = $mandataire;
    }
	
	public function setStatut($statut){
        $this->_statut = $statut;
    }
	
	public function setProvince($province){
		$this->_province = $province;
	}
	
	public function setMp($mp){
		$this->_mp = $mp;
	}
	
	public function setCr($cr){
		$this->_cr = $cr;
	}
	
	public function setQuartier($quartier){
		$this->_quartier = $quartier;
	}
	
    //getters
    
    public function id(){
        return $this->_id;
    }
    
	public function nomClient(){
        return $this->_nomClient;
    }
	
	public function cin(){
        return $this->_cin;
    }
	
	public function telefonClient(){
        return $this->_telefonClient;
    }
	
	public function source(){
        return $this->_source;
    }
	
	public function telefonSource(){
        return $this->_telefonSource;
    }
	
    public function dateRdv(){
        return $this->_dateRdv;
    }
	
	public function heureRdv(){
        return $this->_heureRdv;
    }
	
	public function nature(){
        return $this->_nature;
    }
	
	public function prix(){
		return $this->_prix;
	}
	
	public function mandataire(){
        return $this->_mandataire;
    }
	
	public function statut(){
        return $this->_statut;
    }
	
	public function province(){
		return $this->_province;
	}
	
	public function mp(){
		return $this->_mp;
	}
	
	public function cr(){
		return $this->_cr;
	}
	
	public function quartier(){
		return $this->_quartier;
	}
}