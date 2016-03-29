<?php
class ObservationManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Observation $observation){
        $query = $this->_db->prepare(
        'INSERT INTO t_observation (operation, montant, dateOperation, idCharge)
        VALUES (:operation, :montant, :dateOperation, :idCharge)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':operation', $observation->operation());
		$query->bindValue(':montant', $observation->montant());
		$query->bindValue(':dateOperation', $observation->dateOperation());
		$query->bindValue(':idCharge', $observation->idCharge());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Observation $observation){
		$query = $this->_db->prepare('UPDATE t_observation SET operation=:operation, 
		montant=:montant, dateOperation=:dateOperation 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':operation', $observation->operation());
		$query->bindValue(':montant', $observation->montant());
		$query->bindValue(':dateOperation', $observation->dateOperation());
        $query->bindValue(':id', $observation->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idObservation){
		$query = $this->_db->prepare('DELETE FROM t_observation WHERE id=:idObservation');
		$query->bindValue(':idObservation', $idObservation);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getObservationNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS observationNumbers FROM t_observation');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['observationNumbers'];
    }
	
	public function getObservationById($idObservation){
        $query = $this->_db->prepare('SELECT * FROM t_observation WHERE id=:idObservation');
		$query->bindValue(':idObservation', $idObservation);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Observation($data);
    }
    
    public function getObservationByIdCharge($idCharge){
        $observations = array();
        $query = $this->_db->prepare('SELECT * FROM t_observation WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $observations[] = new Observation($data);
        }
        $query->closeCursor();
        return $observations;
    }
	
	public function getObservationTotalByIdCharge($idCharge){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_observation WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }

	public function getTotalChargesObservation(){
		$query = $this->_db->query('SELECT SUM(montant) AS totalCharges FROM t_observation');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_observation ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}