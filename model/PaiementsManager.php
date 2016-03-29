<?php
class PaiementsManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Paiements $paiements){
        $query = $this->_db->prepare(
        'INSERT INTO t_paiements (montant, dateOperation, idAffaire)
        VALUES (:montant, :dateOperation, :idAffaire)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':montant', $paiements->montant());
		$query->bindValue(':dateOperation', $paiements->dateOperation());
		$query->bindValue(':idAffaire', $paiements->idAffaire());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Paiements $paiements){
		$query = $this->_db->prepare('UPDATE t_paiements SET montant=:montant, dateOperation=:dateOperation 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':montant', $paiements->montant());
		$query->bindValue(':dateOperation', $paiements->dateOperation());
        $query->bindValue(':id', $paiements->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idPaiements){
		$query = $this->_db->prepare('DELETE FROM t_paiements WHERE id=:idPaiements');
		$query->bindValue(':idPaiements', $idPaiements);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getPaiementsNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS paiementsNumbers FROM t_paiements');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['paiementsNumbers'];
    }
	
	public function getPaiementsNumberByIdAffaire($idAffaire){
        $query = $this->_db->prepare('SELECT COUNT(*) AS paiementsNumbers FROM t_paiements WHERE idAffaire=:idAffaire');
		$query->bindValue(':idAffaire', $idAffaire);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['paiementsNumbers'];
    }
	
	public function getPaiementsById($idPaiements){
        $query = $this->_db->prepare('SELECT * FROM t_paiements WHERE id=:id');
		$query->bindValue(':id', $idPaiements);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Paiements($data);
    }
    
    public function getPaiementsByIdAffaire($idAffaire){
        $paiements = array();
        $query = $this->_db->prepare('SELECT * FROM t_paiements WHERE idAffaire=:idAffaire');
		$query->bindValue(':idAffaire', $idAffaire);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $paiements[] = new Paiements($data);
        }
        $query->closeCursor();
        return $paiements;
    }
	
	public function getPaiementsByIdAffaireAndMonth($idAffaire, $dateOperation){
        $paiements = array();
        $query = $this->_db->prepare("SELECT * FROM t_paiements WHERE idAffaire=:idAffaire  
        AND DATE_FORMAT(dateOperation,'%m-%Y')=:moisAnnee");
		$query->bindValue(':idAffaire', $idAffaire);
		$query->bindValue(':moisAnnee', $dateOperation);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $paiements[] = new Paiements($data);
        }
        $query->closeCursor();
        return $paiements;
    }
	
	public function getPaiementsTotalByIdAffaire($idAffaire){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_paiements WHERE idAffaire=:idAffaire');
		$query->bindValue(':idAffaire', $idAffaire);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
	
	public function getPaiementsTotalByIdAffaireAndMonth($idAffaire, $dateOperation){
        $query = $this->_db->prepare("SELECT SUM(montant) as total FROM t_paiements WHERE idAffaire=:idAffaire
        AND DATE_FORMAT(dateOperation,'%m-%Y')=:moisAnnee");
		$query->bindValue(':idAffaire', $idAffaire);
		$query->bindValue(':moisAnnee', $dateOperation);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
	
	public function getPaiementsTotal(){
		$query = $this->_db->query('SELECT SUM(montant) AS totalPaiements FROM t_paiements');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalPaiements'];
        return $totalCharges;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_paiements ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}