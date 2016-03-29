<?php
class ClientManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Client $client){
        $query = $this->_db->prepare('INSERT INTO t_client (nom, numeroTelefon, cin)
                                VALUES (:nom, :numeroTelefon, :cin)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $client->nom());
		$query->bindValue(':cin', $client->cin());
        $query->bindValue(':numeroTelefon', $client->numeroTelefon());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Client $client){
		$query = $this->_db->prepare('UPDATE t_client SET nom=:nom, numeroTelefon=:numeroTelefon,
		cin=:cin WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $client->nom());
		$query->bindValue(':cin', $client->cin());
		$query->bindValue(':numeroTelefon', $client->numeroTelefon());
        $query->bindValue(':id', $client->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idClient){
		$query = $this->_db->prepare('DELETE FROM t_client WHERE id=:idClient');
		$query->bindValue(':idClient', $idClient);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getClientNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS clientNumbers FROM t_client');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['clientNumbers'];
    }
    
    public function getClientById($idClient){
        $query = $this->_db->prepare('SELECT * FROM t_client WHERE id=:idClient');
		$query->bindValue(':idClient', $idClient);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Client($data);
    }
    
    public function getClients(){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new Client($data);
        }
        $query->closeCursor();
        return $clients;
    }
	
	public function getClientsByLimits($begin, $end){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //$query->bindValue(':begin', $begin);
        //$query->bindValue(':end', $end);
        //$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new Client($data);
        }
        $query->closeCursor();
        return $clients;
    }
	
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_client ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idClient){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_client WHERE id=:idClient');
		$query->execute(array(':idClient' => $idClient));
		//get result
		return (bool) $query->fetchColumn();
	}
	
	public function exists2($nom){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_client WHERE nom LIKE :nom');
		$query->bindValue(':nom', '%'.$nom.'%');
		$query->execute();
		//get result
		return (bool) $query->fetchColumn();
	}
	
}