<?php
class SousQuartierManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(SousQuartier $sousQuartier){
        $query = $this->_db->prepare('INSERT INTO t_sousquartier (nom)
                                VALUES (:nom)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $sousQuartier->nom());
        $query->execute();
        $query->closeCursor();
    }
    
	public function update(SousQuartier $sousQuartier){
		$query = $this->_db->prepare('UPDATE t_sousquartier SET nom=:nom WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $sousQuartier->id());
		$query->bindValue(':nom', $sousQuartier->nom());
        $query->execute();
        $query->closeCursor();
	}
		
	public function delete($idSousQuartier){
		$query = $this->_db->prepare('DELETE FROM t_sousquartier WHERE id=:id');
		$query->bindValue(':id', $idSousQuartier);
		$query->execute();
		$query->closeCursor();
	}
	
    public function getSousQuartierNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS sousquartierNumbers FROM t_sousquartier');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['sousquartierNumbers'];
    }
    
    public function getSousQuartiers(){
        $sousQuartiers = array();
        $query = $this->_db->query('SELECT * FROM t_sousquartier ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $sousQuartiers[] = new SousQuartier($data);
        }
        $query->closeCursor();
        return $sousQuartiers;
    }
    
	public function getSousQuartiersByLimits($begin, $end){
        $sousQuartiers = array();
        $query = $this->_db->query('SELECT * FROM t_sousquartier ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $sousQuartiers[] = new Quartier($data);
        }
        $query->closeCursor();
        return $sousQuartiers;
    }
	
	public function getSousQuartierById($idSousQuartier){
        $query = $this->_db->prepare('SELECT * FROM t_sousquartier WHERE id=:id');
		$query->bindValue(':id', $idSousQuartier);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new SousQuartier($data);
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_sousquartier ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idSousQuartier){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_sousquartier WHERE id=:id');
		$query->execute(array(':id' => $idSousQuartier));
		//get result
		return (bool) $query->fetchColumn();
	}
	
	public function exists2($sousQuartier){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_sousquartier WHERE nom LIKE :sousQuartier');
		$query->bindValue(':sousQuartier', '%'.$sousQuartier.'%');
		$query->execute();
		//get result
		return (bool) $query->fetchColumn();
	}
}