<?php
class SortiesManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Sorties $sorties){
        $query = $this->_db->prepare('INSERT INTO t_sorties (dateOperation, montant, statut, user)
                                VALUES (:dateOperation, :montant, :statut, :user)') 
                                or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':dateOperation', $sorties->dateOperation());
        $query->bindValue(':montant', $sorties->montant());
		$query->bindValue(':statut', $sorties->statut());
		$query->bindValue(':user', $sorties->user());
        $query->execute();
        $query->closeCursor();
    }
	
	public function terminerSortiesEnCours(){
		$query = $this->_db->query('UPDATE t_sorties SET statut="archive" 
		WHERE statut="encours"');
        $query->closeCursor();
	}
    
    public function getSortiesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS sortiesNumbers FROM t_sorties');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['sortiesNumbers'];
    }
    
    public function getSortiesKarimTotal(){
        $query = $this->_db->query('SELECT SUM(montant) AS sortiesKarimTotal FROM t_sorties WHERE user="karim" and statut="encours"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['sortiesKarimTotal'];
    }

	public function getSortiesMohamedTotal(){
        $query = $this->_db->query('SELECT SUM(montant) AS sortiesMohamedTotal FROM t_sorties WHERE user="mohamed" and statut="encours"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['sortiesMohamedTotal'];
    }
    
    public function getSortiesEnCoursKarim(){
        $sorties = array();
        $query = $this->_db->prepare('SELECT * FROM t_sorties WHERE statut=:statut AND 
        user=:user ORDER BY dateOperation');
		$query->bindValue(':statut', "encours");
        $query->bindValue(':user', "karim");
        $query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $sorties[] = new Sorties($data);
        }
        $query->closeCursor();
        return $sorties;
    }
	
	public function getSortiesEnCoursMohamed(){
        $sorties = array();
        $query = $this->_db->prepare('SELECT * FROM t_sorties WHERE statut=:statut AND 
        user=:user ORDER BY dateOperation');
		$query->bindValue(':statut', "encours");
        $query->bindValue(':user', "mohamed");
        $query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $sorties[] = new Sorties($data);
        }
        $query->closeCursor();
        return $sorties;
    }
	
	public function getSortiesArchive(){
        $entrees = array();
        $query = $this->_db->query('SELECT * FROM t_sorties ORDER BY dateOperation');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $sorties[] = new Sorties($data);
        }
        $query->closeCursor();
        return $sorties;
    }
    
}