<?php
class ProvinceManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Province $province){
        $query = $this->_db->prepare('INSERT INTO t_province (nom)
        VALUES (:nom)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $province->nom());
        $query->execute();
        $query->closeCursor();
    }
    
	public function update(Province $province){
		$query = $this->_db->prepare('UPDATE t_province SET nom=:nom WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $province->id());
		$query->bindValue(':nom', $province->nom());
        $query->execute();
        $query->closeCursor();
	}
		
	public function delete($idProvince){
		$query = $this->_db->prepare('DELETE FROM t_province WHERE id=:id');
		$query->bindValue(':id', $idProvince);
		$query->execute();
		$query->closeCursor();
	}
	
    public function getProvinceNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS provinceNumbers FROM t_province');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['provinceNumbers'];
    }
    
    public function getProvinces(){
        $provinces = array();
        $query = $this->_db->query('SELECT * FROM t_province ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $provinces[] = new Province($data);
        }
        $query->closeCursor();
        return $provinces;
    }
    
	public function getProvincesByLimits($begin, $end){
        $provinces = array();
        $query = $this->_db->query('SELECT * FROM t_province ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $provinces[] = new Province($data);
        }
        $query->closeCursor();
        return $provinces;
    }
	
	public function getProvinceById($idProvince){
        $query = $this->_db->prepare('SELECT * FROM t_province WHERE id=:id');
		$query->bindValue(':id', $idProvince);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Province($data);
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_province ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idProvince){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_province WHERE id=:id');
		$query->bindValue(':id', $idProvince);
		$query->execute();
		//get result
		return (bool) $query->fetchColumn();
	}
	
	public function exists2($province){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_province WHERE nom LIKE :province');
		$query->bindValue(':province', '%'.$province.'%');
		$query->execute();
		//get result
		return (bool) $query->fetchColumn();
	}
}