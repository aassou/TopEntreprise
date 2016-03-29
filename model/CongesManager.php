<?php
class CongesManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Conges $conges){
        $query = $this->_db->prepare(
        'INSERT INTO t_conges (nom, dateDebut, dateFin)
        VALUES (:nom, :dateDebut, :dateFin)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $conges->nom());
		$query->bindValue(':dateDebut', $conges->dateDebut());
		$query->bindValue(':dateFin', $conges->dateFin());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Conges $conges){
		$query = $this->_db->prepare('UPDATE t_conges SET dateDebut=:dateDebut, dateFin=:dateFin 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':dateDebut', $conges->dateDebut());
		$query->bindValue(':dateFin', $conges->dateFin());
        $query->bindValue(':id', $conges->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idConges){
		$query = $this->_db->prepare('DELETE FROM t_conges WHERE id=:idConges');
		$query->bindValue(':idConges', $idConges);
		$query->execute();
		$query->closeCursor();
	}
    
	public function getConges(){
		$conges = array();	
		$query = $this->_db->query('SELECT * FROM t_conges WHERE MONTHNAME(dateDebut)=MONTHNAME(CURDATE()) ORDER BY dateDebut DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $conges[] = new Conges($data);
        }
        $query->closeCursor();
		return $conges;
	}
	
    public function getCongesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS congesNumbers FROM t_conges');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['congesNumbers'];
    }
	
	public function getCongesById($idConges){
        $query = $this->_db->prepare('SELECT * FROM t_conges WHERE id=:idConges');
		$query->bindValue(':idConges', $idConges);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Conges($data);
    }
	
	public function getCongeBySearch($profil, $annee){
		$query = $this->_db->prepare('SELECT nom, YEAR(dateFin) AS dateDebut, SUM(dateFin-dateDebut) AS dateFin 
		FROM t_conges WHERE YEAR(dateFIN)=:annee AND nom LIKE :profil');
		$query->bindValue(':annee', $annee);
		$query->bindValue(':profil', $profil);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
		return new Conges($data);
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_conges ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}