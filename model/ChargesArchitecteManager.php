<?php
class ChargesArchitecteManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(ChargesArchitecte $charges){
        $query = $this->_db->prepare(
        'INSERT INTO t_charges_architecte (nom, montant, dateCharges, paye, idProjet)
        VALUES (:nom, :montant, :dateCharges, :paye, :idProjet)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $charges->nom());
		$query->bindValue(':montant', $charges->montant());
		$query->bindValue(':dateCharges', $charges->dateCharges());
		$query->bindValue(':paye', $charges->paye());
		$query->bindValue(':idProjet', $charges->idProjet());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(ChargesArchitecte $charges){
		$query = $this->_db->prepare('UPDATE t_charges_architecte SET nom=:nom, montant=:montant,
		dateCharges=:dateCharges, paye=:paye WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $charges->id());
        $query->bindValue(':nom', $charges->nom());
		$query->bindValue(':montant', $charges->montant());
		$query->bindValue(':dateCharges', $charges->dateCharges());
		$query->bindValue(':paye', $charges->paye());
        $query->execute();
        $query->closeCursor();
	}

	public function delete($idCharge){
		$query = $this->_db->prepare('DELETE FROM t_charges_architecte WHERE id=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getChargesArchitecteNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS chargesNumbers FROM t_charges_architecte');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['chargesNumbers'];
    }
    
    public function getChargesArchitecte(){
        $charges = array();
        $query = $this->_db->query('SELECT * FROM t_charges_architecte ORDER BY dateCharges DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new ChargesArchitecte($data);
        }
        $query->closeCursor();
        return $charges;
    }
	
	
	public function getChargesArchitecteNotAttachedToProjects(){
        $charges = array();
        $query = $this->_db->query('SELECT * FROM t_charges_architecte WHERE idProjet=0 ORDER BY dateCharges DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new ChargesArchitecte($data);
        }
        $query->closeCursor();
        return $charges;
    }
	
	public function getChargesArchitecteByLimits($begin, $end){
        $charges = array();
        $query = $this->_db->query('SELECT * FROM t_charges_architecte ORDER BY dateCharges DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new ChargesArchitecte($data);
        }
        $query->closeCursor();
        return $charges;
    }
	
	public function getChargesArchitecteById($idCharge){
        $query = $this->_db->prepare('SELECT * FROM t_charges_architecte WHERE id=:id');
		$query->bindValue(':id', $idCharge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new ChargesArchitecte($data);
    }
	
	public function getChargesArchitecteByIdProjet($idProjet){
		$charges = array();
        $query = $this->_db->prepare('SELECT * FROM t_charges_architecte WHERE idProjet=:idProjet ORDER BY dateCharges');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new ChargesArchitecte($data);
        }
        $query->closeCursor();
        return $charges;
	}
	
	public function getTotalChargesArchitecte(){
		$query = $this->_db->query('SELECT SUM(montant) AS totalCharges FROM t_charges_architecte');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}

	public function getTotalChargesNonPayes(){
		$query = $this->_db->query('SELECT SUM(montant) AS totalCharges FROM t_charges_architecte WHERE paye="non"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}
	
	public function getTotalChargesNonPayesByIdProjet($idProjet){
		$query = $this->_db->prepare('SELECT SUM(montant) AS totalCharges FROM t_charges_architecte WHERE idProjet=:idProjet AND paye="non"');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
       	$data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_charges_architecte ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
}