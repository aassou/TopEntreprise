<?php
class ServiceManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Service $service){
        $query = $this->_db->prepare('INSERT INTO t_service (nom, numeroTelefon, montant, code)
                                VALUES (:nom, :numeroTelefon, :montant)') 
                                or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $service->nom());
        $query->bindValue(':numeroTelefon', $service->numeroTelefon());
		$query->bindValue(':montant', $service->montant());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Service $service){
		$query = $this->_db->prepare('UPDATE t_service SET nom=:nom,
	  	numeroTelefon=:numeroTelefon, montant=:montant WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $service->id());
		$query->bindValue(':nom', $service->nom());
		$query->bindValue(':numeroTelefon', $service->numeroTelefon());
		$query->bindValue(':montant', $service->montant());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idService){
		$query = $this->_db->prepare('DELETE FROM t_service WHERE id=:idService');
		$query->bindValue(':idService', $idService);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getServicesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS serviceNumbers FROM t_service');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['serviceNumbers'];
    }
    
    public function getServices(){
        $services = array();
        $query = $this->_db->query('SELECT * FROM t_service ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $services[] = new Service($data);
        }
        $query->closeCursor();
        return $services;
    }
	
	public function getServicesByLimits($begin, $end){
        $services = array();
        $query = $this->_db->query('SELECT * FROM t_service ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $services[] = new Service($data);
        }
        $query->closeCursor();
        return $services;
    }
	
	public function getServiceById($idService){
        $query = $this->_db->prepare('SELECT * FROM t_service WHERE id=:idService');
		$query->bindValue(':idService', $idService);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Service($data);
    }

	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_service ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
}