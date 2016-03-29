<?php
class ComptableManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Comptable $comptable){
        $query = $this->_db->prepare(
        'INSERT INTO t_comptable (operation, montant, dateOperation, idCharge)
        VALUES (:operation, :montant, :dateOperation, :idCharge)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':operation', $comptable->operation());
		$query->bindValue(':montant', $comptable->montant());
		$query->bindValue(':dateOperation', $comptable->dateOperation());
		$query->bindValue(':idCharge', $comptable->idCharge());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Comptable $comptable){
		$query = $this->_db->prepare('UPDATE t_comptable SET operation=:operation, 
		montant=:montant, dateOperation=:dateOperation 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':operation', $comptable->operation());
		$query->bindValue(':montant', $comptable->montant());
		$query->bindValue(':dateOperation', $comptable->dateOperation());
        $query->bindValue(':id', $comptable->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idComptable){
		$query = $this->_db->prepare('DELETE FROM t_comptable WHERE id=:idComptable');
		$query->bindValue(':idComptable', $idComptable);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getComptableNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS comptableNumbers FROM t_comptable');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['comptableNumbers'];
    }
    
    public function getComptableById($idComptable){
        $query = $this->_db->prepare('SELECT * FROM t_comptable WHERE id=:idComptable');
		$query->bindValue(':idComptable', $idComptable);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Comptable($data);
    }
    
    public function getComptableByIdCharge($idCharge){
        $comptables = array();
        $query = $this->_db->prepare('SELECT * FROM t_comptable WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $comptables[] = new Comptable($data);
        }
        $query->closeCursor();
        return $comptables;
    }
	
	public function getComptableTotalByIdCharge($idCharge){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_comptable WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }

	public function getTotalChargesComptable(){
		$query = $this->_db->query('SELECT SUM(montant) AS totalCharges FROM t_comptable');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_comptable ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
}