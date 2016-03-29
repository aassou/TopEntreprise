<?php
class CnssManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Cnss $cnss){
        $query = $this->_db->prepare(
        'INSERT INTO t_cnss (nom, montant, dateOperation, idCharge)
        VALUES (:nom, :montant, :dateOperation, :idCharge)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $cnss->nom());
		$query->bindValue(':montant', $cnss->montant());
		$query->bindValue(':dateOperation', $cnss->dateOperation());
		$query->bindValue(':idCharge', $cnss->idCharge());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Cnss $cnss){
		$query = $this->_db->prepare('UPDATE t_cnss SET nom=:nom, 
		montant=:montant, dateOperation=:dateOperation 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $cnss->nom());
		$query->bindValue(':montant', $cnss->montant());
		$query->bindValue(':dateOperation', $cnss->dateOperation());
        $query->bindValue(':id', $cnss->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idCnss){
		$query = $this->_db->prepare('DELETE FROM t_cnss WHERE id=:idCnss');
		$query->bindValue(':idCnss', $idCnss);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getCnssNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS cnssNumbers FROM t_cnss');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['cnssNumbers'];
    }
	
	public function getCnssById($idCnss){
        $query = $this->_db->prepare('SELECT * FROM t_cnss WHERE id=:idCnss');
		$query->bindValue(':idCnss', $idCnss);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Cnss($data);
    }
    
    public function getCnssByIdCharge($idCharge){
        $cnss = array();
        $query = $this->_db->prepare('SELECT * FROM t_cnss WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $cnss[] = new Cnss($data);
        }
        $query->closeCursor();
        return $cnss;
    }
	
	public function getCnssTotalByIdCharge($idCharge){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_cnss WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
	
	public function getTotalChargesCnss(){
		$query = $this->_db->query('SELECT SUM(montant) AS totalCharges FROM t_cnss');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_cnss ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}