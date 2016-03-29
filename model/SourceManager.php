<?php
class SourceManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Source $source){
        $query = $this->_db->prepare('INSERT INTO t_source (nom, numeroTelefon, code)
                                VALUES (:nom, :numeroTelefon, :code)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $source->nom());
        $query->bindValue(':numeroTelefon', $source->numeroTelefon());
		$query->bindValue(':code', $source->code());
        $query->execute();
        $query->closeCursor();
    }
    
	public function update(Source $source){
		$query = $this->_db->prepare('UPDATE t_source SET nom=:nom,
	  	numeroTelefon=:numeroTelefon WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $source->id());
		$query->bindValue(':nom', $source->nom());
		$query->bindValue(':numeroTelefon', $source->numeroTelefon());
        $query->execute();
        $query->closeCursor();
	}
		
	public function delete($idSource){
		$query = $this->_db->prepare('DELETE FROM t_source WHERE id=:id');
		$query->bindValue(':id', $idSource);
		$query->execute();
		$query->closeCursor();
	}
	
    public function getSourcesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS sourceNumbers FROM t_source');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['sourceNumbers'];
    }
    
    public function getSources(){
        $sources = array();
        $query = $this->_db->query('SELECT * FROM t_source ORDER BY nom ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $sources[] = new Source($data);
        }
        $query->closeCursor();
        return $sources;
    }
    
	public function getSourcesByLimits($begin, $end){
        $sources = array();
        $query = $this->_db->query('SELECT * FROM t_source ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $sources[] = new Source($data);
        }
        $query->closeCursor();
        return $sources;
    }
	
	public function getSourceBySearch($recherche, $testRadio){
		$query = "";	
		if($testRadio==1){
			$query = $this->_db->prepare("SELECT * FROM t_source WHERE nom LIKE :recherche");
			$query->bindValue(':recherche', '%'.$recherche.'%');
		}
		else if($testRadio==2){
			$query = $this->_db->prepare("SELECT * FROM t_source WHERE code=:code");
			$query->bindValue(':code', $recherche);
		}
		$query->execute();
        $sources = array();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $sources[] = new Source($data);
        }
        $query->closeCursor();
        return $sources;
    }
	
	public function getSourceById($idSource){
        $query = $this->_db->prepare('SELECT * FROM t_source WHERE id=:idSource');
		$query->bindValue(':idSource', $idSource);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Source($data);
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_source ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idSource){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_source WHERE id=:idSource');
		$query->execute(array(':idSource' => $idSource));
		//get result
		return (bool) $query->fetchColumn();
	}
}