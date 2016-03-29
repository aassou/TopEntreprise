<?php
class Affaire{

	//attributes
	private $_id;
    private $_numero;
	private $_dateRdv;
	private $_heureRdv;
	private $_dateSortie;
	private $_nature;
	private $_prix;
	private $_paye;
    private $_nomClient;
    private $_cinClient;
    private $_telephoneClient;
	private $_mandataire;
	private $_status;
	private $_idTopographe;
	private $_idSource;
	private $_idService;
	private $_idClient;
	private $_province;
	private $_mp;
	private $_cr;
	private $_quartier;
	private $_sousquartier;
	private $_propriete;
    private $_nomTopographe;
    private $_telephoneTopographe;
    private $_codeTopographe;
	private $_montantTopographe;
    private $_nomService;
    private $_telephoneService;
    private $_codeService;
	private $_montantService;
    private $_nomSource;
    private $_telephoneSource;
    private $_codeSource;
	private $_montantSource;
	private $_created;
	private $_createdBy;
	private $_updated;
	private $_updatedBy;

	//le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d\'une façon dynamique!
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
    
    public function setNumero($numero){
        $this->_numero = $numero;
    }
    
	public function setDateRdv($dateRdv){
		$this->_dateRdv = $dateRdv;
   	}

	public function setHeureRdv($heureRdv){
		$this->_heureRdv = $heureRdv;
   	}

	public function setDateSortie($dateSortie){
		$this->_dateSortie = $dateSortie;
   	}

	public function setNature($nature){
		$this->_nature = $nature;
   	}

	public function setPrix($prix){
		$this->_prix = $prix;
   	}

	public function setPaye($paye){
		$this->_paye = $paye;
   	}

    public function setNomClient($nomClient){
        $this->_nomClient = $nomClient;
    }
    
    public function setCinClient($cinClient){
        $this->_cinClient = $cinClient;
    }
    
    public function setTelephoneClient($telephoneClient){
        $this->_telephoneClient = $telephoneClient;
    }

	public function setMandataire($mandataire){
		$this->_mandataire = $mandataire;
   	}

	public function setStatus($status){
		$this->_status = $status;
   	}

	public function setIdTopographe($idTopographe){
		$this->_idTopographe = $idTopographe;
   	}

	public function setIdSource($idSource){
		$this->_idSource = $idSource;
   	}

	public function setIdService($idService){
		$this->_idService = $idService;
   	}

	public function setIdClient($idClient){
		$this->_idClient = $idClient;
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

	public function setSousquartier($sousquartier){
		$this->_sousquartier = $sousquartier;
   	}

	public function setPropriete($propriete){
		$this->_propriete = $propriete;
   	}

    public function setNomTopographe($nomTopographe){
        $this->_nomTopographe = $nomTopographe;
    }
    
    public function setTelephoneTopographe($telephoneTopographe){
        $this->_telephoneTopographe = $telephoneTopographe;
    }

	public function setMontantTopographe($montantTopographe){
		$this->_montantTopographe = $montantTopographe;
   	}

    public function setNomService($nomService){
        $this->_nomService = $nomService;
    }
    
    public function setTelephoneService($telephoneService){
        $this->_telephoneService = $telephoneService;
    }

	public function setMontantService($montantService){
		$this->_montantService = $montantService;
   	}

    public function setNomSource($nomSource){
        $this->_nomSource = $nomSource;
    }
    
    public function setTelephoneSource($telephoneSource){
        $this->_telephoneSource = $telephoneSource;
    }

    public function setMontantSource($montantSource){
        $this->_montantSource = $montantSource;
    }

	public function setCreated($created){
        $this->_created = $created;
    }

	public function setCreatedBy($createdBy){
        $this->_createdBy = $createdBy;
    }

	public function setUpdated($updated){
        $this->_updated = $updated;
    }

	public function setUpdatedBy($updatedBy){
        $this->_updatedBy = $updatedBy;
    }

	//getters
	public function id(){
    	return $this->_id;
    }
    
    public function numero(){
        return $this->_numero;
    }
    
	public function dateRdv(){
		return $this->_dateRdv;
   	}

	public function heureRdv(){
		return $this->_heureRdv;
   	}

	public function dateSortie(){
		return $this->_dateSortie;
   	}

	public function nature(){
		return $this->_nature;
   	}

	public function prix(){
		return $this->_prix;
   	}

	public function paye(){
		return $this->_paye;
   	}

    public function nomClient(){
        return $this->_nomClient;
    }
    
    public function cinClient(){
        return $this->_cinClient;
    }
    
    public function telephoneClient(){
        return $this->_telephoneClient;
    }

	public function mandataire(){
		return $this->_mandataire;
   	}

	public function status(){
		return $this->_status;
   	}

	public function idTopographe(){
		return $this->_idTopographe;
   	}

	public function idSource(){
		return $this->_idSource;
   	}

	public function idService(){
		return $this->_idService;
   	}

	public function idClient(){
		return $this->_idClient;
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

	public function sousquartier(){
		return $this->_sousquartier;
   	}

	public function propriete(){
		return $this->_propriete;
   	}

    public function nomTopographe(){
        return $this->_nomTopographe;
    }
    
    public function telephoneTopographe(){
        return $this->_telephoneTopographe;
    }
    
	public function montantTopographe(){
		return $this->_montantTopographe;
   	}

    public function nomService(){
        return $this->_nomService;
    }
    
    public function telephoneService(){
        return $this->_telephoneService;
    }

	public function montantService(){
		return $this->_montantService;
   	}
    
    public function nomSource(){
        return $this->_nomSource;
    }
    
    public function telephoneSource(){
        return $this->_telephoneSource;
    }
    
	public function montantSource(){
		return $this->_montantSource;
   	}

	public function created(){
        return $this->_created;
    }

	public function createdBy(){
        return $this->_createdBy;
    }

	public function updated(){
        return $this->_updated;
    }

	public function updatedBy(){
        return $this->_updatedBy;
    }

}