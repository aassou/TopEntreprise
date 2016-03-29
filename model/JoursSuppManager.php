<?php
class JoursSuppManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(JoursSupp $joursSupp){
        $query = $this->_db->prepare(
        'INSERT INTO t_jours_supp (nom, dateTravail)
        VALUES (:nom, :dateTravail)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $joursSupp->nom());
		$query->bindValue(':dateTravail', $joursSupp->dateTravail());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(JoursSupp $joursSupp){
		$query = $this->_db->prepare('UPDATE t_jours_supp SET dateTravail=:dateTravail 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':dateTravail', $joursSupp->dateTravail());
        $query->bindValue(':id', $joursSupp->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idJoursSupp){
		$query = $this->_db->prepare('DELETE FROM t_jours_supp WHERE id=:idJoursSupp');
		$query->bindValue(':idJoursSupp', $idJoursSupp);
		$query->execute();
		$query->closeCursor();
	}
    
	public function getJoursSupp(){
		$jours = array();	
		$query = $this->_db->query('SELECT * FROM t_jours_supp WHERE MONTHNAME(dateTravail)=MONTHNAME(CURDATE()) ORDER BY dateTravail DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $jours[] = new JoursSupp($data);
        }
        $query->closeCursor();
		return $jours;
	}
	
    public function getJoursSuppNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS joursSuppNumbers FROM t_jours_supp');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['joursSuppNumbers'];
    }
	
	public function getJoursSuppById($idJoursSupp){
        $query = $this->_db->prepare('SELECT * FROM t_jours_supp WHERE id=:idJoursSupp');
		$query->bindValue(':idJoursSupp', $idJoursSupp);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new JoursSupp($data);
    }
	
	public function getJoursSuppBySearch($profil, $annee){
		$query = $this->_db->prepare('SELECT nom, YEAR(dateTravail) AS dateDebut, SUM(dateTravail) AS id 
		FROM t_jours_supp WHERE YEAR(dateTravail)=:annee AND nom LIKE :profil');
		$query->bindValue(':annee', $annee);
		$query->bindValue(':profil', $profil);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
		return new Conges($data);
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_jours_supp ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}