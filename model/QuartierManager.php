<?php
class QuartierManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Quartier $quartier){
        $query = $this->_db->prepare('INSERT INTO t_quartier (nom)
                                VALUES (:nom)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $quartier->nom());
        $query->execute();
        $query->closeCursor();
    }
    
	public function update(Quartier $quartier){
		$query = $this->_db->prepare('UPDATE t_quartier SET nom=:nom WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $quartier->id());
		$query->bindValue(':nom', $quartier->nom());
        $query->execute();
        $query->closeCursor();
	}
		
	public function delete($idQuartier){
		$query = $this->_db->prepare('DELETE FROM t_quartier WHERE id=:id');
		$query->bindValue(':id', $idQuartier);
		$query->execute();
		$query->closeCursor();
	}
	
    public function getQuartierNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS quartierNumbers FROM t_quartier');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['quartierNumbers'];
    }
    
    public function getQuartiers(){
        $quartiers = array();
        $query = $this->_db->query('SELECT * FROM t_quartier ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $quartiers[] = new Quartier($data);
        }
        $query->closeCursor();
        return $quartiers;
    }
    
	public function getQuartiersByLimits($begin, $end){
        $quartiers = array();
        $query = $this->_db->query('SELECT * FROM t_quartier ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $quartiers[] = new Quartier($data);
        }
        $query->closeCursor();
        return $quartiers;
    }
	
	public function getQuartierById($idQuartier){
        $query = $this->_db->prepare('SELECT * FROM t_quartier WHERE id=:id');
		$query->bindValue(':id', $idQuartier);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Quartier($data);
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_quartier ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idQuartier){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_quartier WHERE id=:id');
		$query->execute(array(':id' => $idQuartier));
		//get result
		return (bool) $query->fetchColumn();
	}
	
	public function exists2($quartier){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_quartier WHERE nom LIKE :quartier');
		$query->bindValue(':quartier', '%'.$quartier.'%');
		$query->execute();
		//get result
		return (bool) $query->fetchColumn();
	}
}