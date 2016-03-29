<?php
class VoitureManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Voiture $voiture){
        $query = $this->_db->prepare(
        'INSERT INTO t_voiture (operation, montant, dateOperation, idCharge)
        VALUES (:operation, :montant, :dateOperation, :idCharge)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':operation', $voiture->operation());
		$query->bindValue(':montant', $voiture->montant());
		$query->bindValue(':dateOperation', $voiture->dateOperation());
		$query->bindValue(':idCharge', $voiture->idCharge());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Voiture $voiture){
		$query = $this->_db->prepare('UPDATE t_voiture SET operation=:operation, 
		montant=:montant, dateOperation=:dateOperation 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':operation', $voiture->operation());
		$query->bindValue(':montant', $voiture->montant());
		$query->bindValue(':dateOperation', $voiture->dateOperation());
        $query->bindValue(':id', $voiture->id());
        $query->execute();
        $query->closeCursor();
	}

	public function delete($idVoiture){
		$query = $this->_db->prepare('DELETE FROM t_voiture WHERE id=:idVoiture');
		$query->bindValue(':idVoiture', $idVoiture);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getVoitureNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS voitureNumbers FROM t_voiture');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['voitureNumbers'];
    }
    
    public function getVoitureById($idVoiture){
        $query = $this->_db->prepare('SELECT * FROM t_voiture WHERE id=:idVoiture');
		$query->bindValue(':idVoiture', $idVoiture);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Voiture($data);
    }
    
    public function getVoitureByIdCharge($idCharge){
        $voitures = array();
        $query = $this->_db->prepare('SELECT * FROM t_voiture WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $voitures[] = new Voiture($data);
        }
        $query->closeCursor();
        return $voitures;
    }
	
	public function getVoitureByIdChargeByLimits($idCharge, $begin, $end){
        $voitures = array();
        $query = $this->_db->prepare('SELECT * FROM t_voiture WHERE idCharge=:idCharge ORDER BY dateCharges DESC LIMIT '.$begin.' , '.$end);
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $voitures[] = new Voiture($data);
        }
        $query->closeCursor();
        return $voitures;
    }
	
	public function getVoitureTotalByIdCharge($idCharge){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_voiture WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
	
	public function getTotalChargesVoiture(){
		$query = $this->_db->query('SELECT SUM(montant) AS totalCharges FROM t_voiture');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_voiture ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
}