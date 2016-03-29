<?php
class FacturesManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Factures $factures){
        $query = $this->_db->prepare(
        'INSERT INTO t_factures (chemin, idCharge, categorie)
        VALUES (:chemin, :idCharge, :categorie)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':chemin', $factures->chemin());
		$query->bindValue(':idCharge', $factures->idCharge());
		$query->bindValue(':categorie', $factures->categorie());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Factures $factures){
		$query = $this->_db->prepare('UPDATE t_factures SET chemin=:chemin, 
		idCharge=:idCharge, categorie=:categorie WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':chemin', $factures->chemin());
		$query->bindValue(':idCharges', $factures->idCharge());
		$query->bindValue(':categorie', $factures->categorie());
        $query->bindValue(':id', $factures->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idFactures){
		$query = $this->_db->prepare('DELETE FROM t_factures WHERE id=:id');
		$query->bindValue(':id', $idFactures);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getFacturesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS facturesNumbers FROM t_factures');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['facturesNumbers'];
    }
	
	public function getFacturesById($idFactures){
        $query = $this->_db->prepare('SELECT * FROM t_factures WHERE id=:id');
		$query->bindValue(':id', $idFactures);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Factures($data);
    }
    
    public function getFacturesByIdCharge($idCharge){
        $factures = array();
        $query = $this->_db->prepare('SELECT * FROM t_factures WHERE idCharge=:idCharge');
		$query->bindValue(':idCharge', $idCharge);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $factures[] = new Factures($data);
        }
        $query->closeCursor();
        return $factures;
    }
	
	public function getFacturesBySearch($categorie, $moisAnnee){
        $factures = array();
        $query = $this->_db->prepare("SELECT f.id, f.chemin, f.idCharge, f.categorie, c.dateCharges 
        FROM t_factures f INNER JOIN t_charges c ON f.idCharge=c.id 
        WHERE DATE_FORMAT(c.dateCharges,'%m-%Y')=:moisAnnee AND f.categorie=:categorie ");
		$query->bindValue(':moisAnnee', $moisAnnee);
		$query->bindValue(':categorie', $categorie);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $factures[] = new Factures($data);
        }
        $query->closeCursor();
        return $factures;
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_cnss ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}