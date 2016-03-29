<?php
class TacheManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Tache $tache){
        $query = $this->_db->prepare('INSERT INTO t_tache (nom, description, checked, idProjet)
        VALUES (:nom, :description, :checked, :idProjet)') 
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $tache->nom());
		$query->bindValue(':description', $tache->description());
		$query->bindValue(':checked', $tache->checked());
		$query->bindValue(':idProjet', $tache->idProjet());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Tache $tache){
		$query = $this->_db->prepare('UPDATE t_tache SET nom=:nom, description=:description WHERE id=:idTache') 
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idTache', $tache->id());
		$query->bindValue(':nom', $tache->nom());
		$query->bindValue(':description', $tache->description());
        $query->execute();
        $query->closeCursor();
	}
	
	public function getStatus($idTache){
		$query = $this->_db->prepare('SELECT checked FROM t_tache WHERE id=:idTache');
		$query->bindValue(':idTache', $idTache);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['checked'];
	}
	
	public function changeStatus($idTache, $status){
		$query = $this->_db->prepare('UPDATE t_tache SET checked=:checked WHERE id=:idTache')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idTache', $idTache);
		$query->bindValue(':checked', $status);
		$query->execute();
		$query->closeCursor();
	}
	
	public function changeStatusOn($idTache){
		$query = $this->_db->prepare('UPDATE t_tache SET checked="checked" WHERE id=:idTache')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idTache', $idTache);
		$query->execute();
		$query->closeCursor();
	}
	
	public function changeStatusOff($idTache){
		$query = $this->_db->prepare('UPDATE t_tache SET checked="" WHERE id=:idTache')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idTache', $idTache);
		$query->execute();
		$query->closeCursor();
	}
	
	public function delete($idTache){
		$query = $this->_db->prepare('DELETE FROM t_tache WHERE id=:idTache');
		$query->bindValue(':idTache', $idTache);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getTacheNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS tacheNumbers FROM t_tache');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['tacheNumbers'];
    }
	
	public function getCheckedTacheNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS tacheNumbers FROM t_tache 
        WHERE checked="checked" AND idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
       	$data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['tacheNumbers'];
    }
	
	public function getTacheNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS tacheNumbers FROM t_tache WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
       	$data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['tacheNumbers'];
    }
    
    public function getTacheById($idTache){
        $query = $this->_db->prepare('SELECT * FROM t_tache WHERE id=:idTache');
		$query->bindValue(':idTache', $idTache);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Tache($data);
    }
    
    public function getTaches(){
        $taches = array();
        $query = $this->_db->query('SELECT * FROM t_tache ORDER BY checked');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $taches[] = new Tache($data);
        }
        $query->closeCursor();
        return $taches;
    }
	
	public function getTachesByIdProjet($idProjet){
        $taches = array();
        $query = $this->_db->prepare('SELECT * FROM t_tache WHERE idProjet=:idProjet ORDER BY id');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $taches[] = new Tache($data);
        }
        $query->closeCursor();
        return $taches;
    }
	
	public function getTachesByLimits($begin, $end){
        $taches = array();
        $query = $this->_db->query('SELECT * FROM t_tache ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $taches[] = new Tache($data);
        }
        $query->closeCursor();
        return $taches;
    }
	
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_tache ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idTache){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_tache WHERE id=:idTache');
		$query->execute(array(':idTache' => $idTache));
		//get result
		return (bool) $query->fetchColumn();
	}
	
}