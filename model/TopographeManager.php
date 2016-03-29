<?php
class TopographeManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Topographe $topographe){
        $query = $this->_db->prepare('INSERT INTO t_topographe (nom, numeroTelefon, montant, code)
                                VALUES (:nom, :numeroTelefon, :montant, :code)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $topographe->nom());
        $query->bindValue(':numeroTelefon', $topographe->numeroTelefon());
		$query->bindValue(':montant', $topographe->montant());
		$query->bindValue(':code', $topographe->code());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Topographe $topographe){
		$query = $this->_db->prepare('UPDATE t_topographe SET nom=:nom,
	  	numeroTelefon=:numeroTelefon, montant=:montant WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $topographe->id());
		$query->bindValue(':nom', $topographe->nom());
		$query->bindValue(':numeroTelefon', $topographe->numeroTelefon());
		$query->bindValue(':montant', $topographe->montant());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idTopographe){
		$query = $this->_db->prepare('DELETE FROM t_topographe WHERE id=:id');
		$query->bindValue(':id', $idTopographe);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getTopographesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS topographeNumbers FROM t_topographe');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['topographeNumbers'];
    }
    
    public function getTopographes(){
        $topographes = array();
        $query = $this->_db->query('SELECT * FROM t_topographe ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $topographes[] = new Topographe($data);
        }
        $query->closeCursor();
        return $topographes;
    }
	
	public function getTopographeBySearch($recherche, $testRadio){
		$query = "";	
		if($testRadio==1){
			$query = $this->_db->prepare("SELECT * FROM t_topographe WHERE nom LIKE :recherche");
			$query->bindValue(':recherche', '%'.$recherche.'%');
		}
		else if($testRadio==2){
			$query = $this->_db->prepare("SELECT * FROM t_topographe WHERE code=:code");
			$query->bindValue(':code', $recherche);
		}
		$query->execute();
        $topographes = array();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $topographes[] = new Topographe($data);
        }
        $query->closeCursor();
        return $topographes;
    }

	public function getTopographeById($idTopographe){
        $query = $this->_db->prepare('SELECT * FROM t_topographe WHERE id=:idTopographe');
		$query->bindValue(':idTopographe', $idTopographe);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Topographe($data);
    }
	
	public function getTopographesByLimits($begin, $end){
        $topographes = array();
        $query = $this->_db->query('SELECT * FROM t_topographe ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $topographes[] = new Topographe($data);
        }
        $query->closeCursor();
        return $topographes;
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_topographe ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
}