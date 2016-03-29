<?php
class ZoneManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Zone $zone){
        $query = $this->_db->prepare('INSERT INTO t_zone (nom, observation)
                                VALUES (:nom, :observation)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $zone->nom());
        $query->bindValue(':observation', $zone->observation());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Zone $zone){
		$query = $this->_db->prepare('UPDATE t_zone SET nom=:nom, observation=:observation 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $zone->nom());
		$query->bindValue(':observation', $zone->observation());
        $query->bindValue(':id', $zone->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idZone){
		$query = $this->_db->prepare('DELETE FROM t_zone WHERE id=:idZone');
		$query->bindValue(':idZone', $idZone);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getZoneNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS zoneNumbers FROM t_zone');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['zoneNumbers'];
    }
    
    public function getZoneById($idZone){
        $query = $this->_db->prepare('SELECT * FROM t_zone WHERE id=:idZone');
		$query->bindValue(':idZone', $idZone);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Zone($data);
    }
    
    public function getZones(){
        $zones = array();
        $query = $this->_db->query('SELECT * FROM t_zone ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $zones[] = new Zone($data);
        }
        $query->closeCursor();
        return $zones;
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_zone ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
}