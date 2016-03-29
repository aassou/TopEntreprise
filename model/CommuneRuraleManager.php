<?php
class CommuneRuraleManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(CommuneRurale $communeRurale){
        $query = $this->_db->prepare('INSERT INTO t_communerurale (nom)
                                VALUES (:nom)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $communeRurale->nom());
        $query->execute();
        $query->closeCursor();
    }
    
	public function update(CommuneRurale $communeRurale){
		$query = $this->_db->prepare('UPDATE t_communerurale SET nom=:nom WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $communeRurale->id());
		$query->bindValue(':nom', $communeRurale->nom());
        $query->execute();
        $query->closeCursor();
	}
		
	public function delete($idCommuneRurale){
		$query = $this->_db->prepare('DELETE FROM t_communerurale WHERE id=:id');
		$query->bindValue(':id', $idCommuneRurale);
		$query->execute();
		$query->closeCursor();
	}
	
    public function getCommuneRuraleNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS communeRuraleNumbers FROM t_communerurale');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['communeRuraleNumbers'];
    }
    
    public function getCommuneRurales(){
        $communeRurales = array();
        $query = $this->_db->query('SELECT * FROM t_communerurale ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $communeRurales[] = new CommuneRurale($data);
        }
        $query->closeCursor();
        return $communeRurales;
    }
    
	public function getCommuneRuralesByLimits($begin, $end){
        $communeRurales = array();
        $query = $this->_db->query('SELECT * FROM t_communerurale ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $communeRurales[] = new CommuneRurale($data);
        }
        $query->closeCursor();
        return $communeRurales;
    }
	
	public function getCommuneRuraleById($idCommuneRurale){
        $query = $this->_db->prepare('SELECT * FROM t_communerurale WHERE id=:id');
		$query->bindValue(':id', $idCommuneRurale);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new CommuneRurale($data);
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_communerurale ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idCommuneRurale){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_communerurale WHERE id=:id');
		$query->execute(array(':id' => $idCommuneRurale));
		//get result
		return (bool) $query->fetchColumn();
	}
	
	public function exists2($cr){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_communerurale WHERE nom LIKE :cr');
		$query->bindValue(':cr', '%'.$cr.'%');
		$query->execute();
		//get result
		return (bool) $query->fetchColumn();
	}
}