<?php
class Tache{
	
    //attributes
    private $_id;
    private $_nom;
    private $_description;
    private $_checked;
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
	
	public function setDescription($description){
        $this->_description = $description;
    }
	
	public function setChecked($checked){
        $this->_checked = $checked;
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
    
    public function description(){
        return $this->_description;
    }
	
	public function checked(){
        return $this->_checked;
    }
	
	public function idProjet(){
        return $this->_idProjet;
    }   
}