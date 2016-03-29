<?php
class EntreesManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Entrees $entrees){
        $query = $this->_db->prepare('INSERT INTO t_entrees (dateOperation, montant, statut, user)
                                VALUES (:dateOperation, :montant, :statut, :user)') 
                                or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':dateOperation', $entrees->dateOperation());
        $query->bindValue(':montant', $entrees->montant());
		$query->bindValue(':statut', $entrees->statut());
		$query->bindValue(':user', $entrees->user());
        $query->execute();
        $query->closeCursor();
    }
	
	public function terminerEntreesEnCours(){
		$query = $this->_db->query('UPDATE t_entrees SET statut="archive" 
		WHERE statut="encours"');
        $query->closeCursor();
	}
    
    public function getEntreesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS entreesNumbers FROM t_entrees');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['entreesNumbers'];
    }
	
	public function getEntreesKarimTotal(){
        $query = $this->_db->query('SELECT SUM(montant) AS entreesKarimTotal FROM t_entrees WHERE user="karim" and statut="encours"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['entreesKarimTotal'];
    }

	public function getEntreesMohamedTotal(){
        $query = $this->_db->query('SELECT SUM(montant) AS entreesMohamedTotal FROM t_entrees WHERE user="mohamed" and statut="encours"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['entreesMohamedTotal'];
    }
    
    
    public function getEntreesEnCoursKarim(){
        $entrees = array();
        $query = $this->_db->prepare('SELECT * FROM t_entrees WHERE statut=:statut AND 
        user=:user ORDER BY dateOperation');
		$query->bindValue(':statut', "encours");
        $query->bindValue(':user', "karim");
        $query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $entrees[] = new Entrees($data);
        }
        $query->closeCursor();
        return $entrees;
    }
	
	public function getEntreesEnCoursMohamed(){
        $entrees = array();
        $query = $this->_db->prepare('SELECT * FROM t_entrees WHERE statut=:statut AND 
        user=:user ORDER BY dateOperation');
		$query->bindValue(':statut', "encours");
        $query->bindValue(':user', "mohamed");
        $query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $entrees[] = new Entrees($data);
        }
        $query->closeCursor();
        return $entrees;
    }
	
	public function getEntreesArchive(){
        $entrees = array();
        $query = $this->_db->query('SELECT * FROM t_entrees ORDER BY dateOperation');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $entrees[] = new Entrees($data);
        }
        $query->closeCursor();
        return $entrees;
    }
    
}