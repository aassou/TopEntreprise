<?php
class SalairesManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Salaires $salaires){
        $query = $this->_db->prepare(
        'INSERT INTO t_salaires (nom, montant, prime, dateOperation, idCharge)
        VALUES (:nom, :montant, :prime, :dateOperation, :idCharge)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $salaires->nom());
		$query->bindValue(':montant', $salaires->montant());
		$query->bindValue(':prime', $salaires->prime());
		$query->bindValue(':dateOperation', $salaires->dateOperation());
		$query->bindValue(':idCharge', $salaires->idCharge());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Salaires $salaire){
		$query = $this->_db->prepare('UPDATE t_salaires SET nom=:nom, 
		montant=:montant, prime=:prime, dateOperation=:dateOperation 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $salaire->nom());
		$query->bindValue(':montant', $salaire->montant());
		$query->bindValue(':prime', $salaire->prime());
		$query->bindValue(':dateOperation', $salaire->dateOperation());
        $query->bindValue(':id', $salaire->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idSalaire){
		$query = $this->_db->prepare('DELETE FROM t_salaires WHERE id=:idSalaire');
		$query->bindValue(':idSalaire', $idSalaire);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getSalairesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS salairesNumbers FROM t_salaires');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['salairesNumbers'];
    }
	
	public function getSalaireById($idSalaire){
        $query = $this->_db->prepare('SELECT * FROM t_salaires WHERE id=:idSalaire');
		$query->bindValue(':idSalaire', $idSalaire);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Salaires($data);
    }
    
    public function getSalairesByIdCharge($idCharge){
        $salaires = array();
        $query = $this->_db->prepare('SELECT * FROM t_salaires WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $salaires[] = new Salaires($data);
        }
        $query->closeCursor();
        return $salaires;
    }
	
	public function getSalairesTotalMontantByIdCharge($idCharge){
        $query = $this->_db->prepare('SELECT SUM(montant) as totalMontant FROM t_salaires WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['totalMontant'];
    }
	
	public function getSalairesTotalPrimeByIdCharge($idCharge){
        $query = $this->_db->prepare('SELECT SUM(prime) as totalPrime FROM t_salaires WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['totalPrime'];
    }
	
	public function getTotalChargesSalaires(){
		$query = $this->_db->query('SELECT (SUM(montant)+SUM(prime)) AS totalCharges FROM t_salaires');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_salaires ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}