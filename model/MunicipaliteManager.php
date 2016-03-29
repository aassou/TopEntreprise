<?php
class MunicipaliteManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Municipalite $municipalite){
        $query = $this->_db->prepare('INSERT INTO t_municipalite (nom)
                                VALUES (:nom)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $municipalite->nom());
        $query->execute();
        $query->closeCursor();
    }
    
	public function update(Municipalite $municipalite){
		$query = $this->_db->prepare('UPDATE t_municipalite SET nom=:nom WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $municipalite->id());
		$query->bindValue(':nom', $municipalite->nom());
        $query->execute();
        $query->closeCursor();
	}
		
	public function delete($idMunicipalite){
		$query = $this->_db->prepare('DELETE FROM t_municipalite WHERE id=:id');
		$query->bindValue(':id', $idMunicipalite);
		$query->execute();
		$query->closeCursor();
	}
	
    public function getMunicipaliteNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS municipaliteNumbers FROM t_municipalite');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['municipaliteNumbers'];
    }
    
    public function getMunicipalites(){
        $municipalites = array();
        $query = $this->_db->query('SELECT * FROM t_municipalite ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $municipalites[] = new Municipalite($data);
        }
        $query->closeCursor();
        return $municipalites;
    }
    
	public function getMunicipalitesByLimits($begin, $end){
        $municipalites = array();
        $query = $this->_db->query('SELECT * FROM t_municipalite ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $municipalites[] = new Municipalite($data);
        }
        $query->closeCursor();
        return $municipalites;
    }
	
	public function getMunicipaliteById($idMunicipalite){
        $query = $this->_db->prepare('SELECT * FROM t_municipalite WHERE id=:id');
		$query->bindValue(':id', $idMunicipalite);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Municipalite($data);
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_municipalite ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idMunicipalites){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_municipalite WHERE id=:id');
		$query->execute(array(':id' => $idMunicipalites));
		//get result
		return (bool) $query->fetchColumn();
	}
	
	public function exists2($mp){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_municipalite WHERE nom LIKE :mp');
		$query->bindValue(':mp', '%'.$mp.'%');
		$query->execute();
		//get result
		return (bool) $query->fetchColumn();
	}
}