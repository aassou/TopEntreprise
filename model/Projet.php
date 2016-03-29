<?php
class Projet{
	
    //attributes
    private $_id;
    private $_leve;
    private $_dateCreation;
	private $_dateFin;
	private $_nom;
	private $_type;
	private $_objet;
	private $_prix;
	private $_paye;
	private $_architecte;
	private $_statut;
	private $_titre;
	private $_ilot;
	private $_lot;
	private $_idClient;
    
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
    
    public function setLeve($leve){
        $this->_leve = $leve;
    }
	
	public function setDateCreation($dateCreation){
        $this->_dateCreation = $dateCreation;
    }
	
	public function setDateFin($dateFin){
        $this->_dateFin = $dateFin;
    }
	
	public function setNom($nom){
        $this->_nom = $nom;
    }
	
	public function setType($type){
        $this->_type = $type;
    }
	
	public function setObjet($objet){
        $this->_objet = $objet;
    }
	
	public function setPrix($prix){
        $this->_prix = $prix;
    }
	
	public function setPaye($paye){
        $this->_paye = $paye;
    }
	
	public function setArchitecte($architecte){
        $this->_architecte = $architecte;
    }
	
	public function setStatut($statut){
        $this->_statut = $statut;
    }
	
	public function setTitre($titre){
        $this->_titre = $titre;
    }
	
	public function setLot($lot){
        $this->_lot = $lot;
    }
    
	public function setIlot($ilot){
        $this->_ilot = $ilot;
    }
	
	public function setIdClient($idClient){
        $this->_idClient = $idClient;
    }
    //getters
    public function id(){
        return $this->_id;
    }
    
	public function leve(){
        return $this->_leve;
    }
	
	public function dateCreation(){
        return $this->_dateCreation;
    }
	
	public function dateFin(){
        return $this->_dateFin;
    }
	
    public function nom(){
        return $this->_nom;
    }
    
    public function type(){
        return $this->_type;
    }
	
	public function objet(){
        return $this->_objet;
    }
	
	public function prix(){
        return $this->_prix;
    }
	
	public function paye(){
        return $this->_paye;
    }
	
	public function architecte(){
        return $this->_architecte;
    }
	
	public function statut(){
        return $this->_statut;
    }
	
	public function titre(){
        return $this->_titre;
    }
    
	public function ilot(){
        return $this->_ilot;
    }
	
	public function lot(){
        return $this->_lot;
    }
    
    public function idClient(){
        return $this->_idClient;
    }
        
}