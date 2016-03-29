<?php
class ClientArchitecteManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(ClientArchitecte $client){
        $query = $this->_db->prepare('INSERT INTO t_client_architecte (nom, numeroTelefon)
                                VALUES (:nom, :numeroTelefon)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $client->nom());
        $query->bindValue(':numeroTelefon', $client->numeroTelefon());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(ClientArchitecte $client){
		$query = $this->_db->prepare('UPDATE t_client_architecte SET nom=:nom, numeroTelefon=:numeroTelefon
		 WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $client->nom());
		$query->bindValue(':numeroTelefon', $client->numeroTelefon());
        $query->bindValue(':id', $client->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idClient){
		$query = $this->_db->prepare('DELETE FROM t_client_architecte WHERE id=:idClient');
		$query->bindValue(':idClient', $idClient);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getClientArchitecteNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS clientNumbers FROM t_client_architecte');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['clientNumbers'];
    }
    
    public function getClientArchitecteById($idClient){
        $query = $this->_db->prepare('SELECT * FROM t_client_architecte WHERE id=:idClient');
		$query->bindValue(':idClient', $idClient);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new ClientArchitecte($data);
    }
    
    public function getClientsArchitecte(){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client_architecte ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new ClientArchitecte($data);
        }
        $query->closeCursor();
        return $clients;
    }
	
	public function getClientsArchitecteByLimits($begin, $end){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client_architecte ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new ClientArchitecte($data);
        }
        $query->closeCursor();
        return $clients;
    }
	
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_client_architecte ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idClient){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_client_architecte WHERE id=:idClient');
		$query->execute(array(':idClient' => $idClient));
		//get result
		return (bool) $query->fetchColumn();
	}
	
}