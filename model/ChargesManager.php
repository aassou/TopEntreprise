<?php
class ChargesManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Charges $charges){
        $query = $this->_db->prepare(
        'INSERT INTO t_charges (eau, electricite, fixe, portable, internet,
        loyer, dateCharges)
        VALUES (:eau, :electricite, :fixe, :portable, :internet,
        :loyer, :dateCharges)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':eau', $charges->eau());
		$query->bindValue(':electricite', $charges->electricite());
		$query->bindValue(':fixe', $charges->fixe());
		$query->bindValue(':portable', $charges->portable());
		$query->bindValue(':internet', $charges->internet());
		$query->bindValue(':loyer', $charges->loyer());
		$query->bindValue(':dateCharges', $charges->dateCharges());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Charges $charges){
		$query = $this->_db->prepare('UPDATE t_charges SET eau=:eau, electricite=:electricite, fixe=:fixe,
		portable=:portable, internet=:internet, loyer=:loyer, dateCharges=:dateCharges 
		WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':eau', $charges->eau());
		$query->bindValue(':electricite', $charges->electricite());
		$query->bindValue(':fixe', $charges->fixe());
		$query->bindValue(':portable', $charges->portable());
		$query->bindValue(':internet', $charges->internet());
		$query->bindValue(':loyer', $charges->loyer());
		$query->bindValue(':dateCharges', $charges->dateCharges());
        $query->bindValue(':id', $charges->id());
        $query->execute();
        $query->closeCursor();
	}
    
    public function getChargesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS chargesNumbers FROM t_charges');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['chargesNumbers'];
    }
    
    public function getCharges(){
        $charges = array();
        $query = $this->_db->query('SELECT * FROM t_charges ORDER BY dateCharges DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new Charges($data);
        }
        $query->closeCursor();
        return $charges;
    }
	
	public function getChargesByLimits($begin, $end){
        $charges = array();
        $query = $this->_db->query('SELECT * FROM t_charges ORDER BY dateCharges DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new Charges($data);
        }
        $query->closeCursor();
        return $charges;
    }
	
	public function getChargesById($idCharge){
        $query = $this->_db->prepare('SELECT * FROM t_charges WHERE id=:id');
		$query->bindValue(':id', $idCharge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Charges($data);
    }
	
	public function getTotalCharges(){
		$query = $this->_db->query('SELECT (SUM(eau)+SUM(electricite)+SUM(loyer)+SUM(fixe)+SUM(portable)+SUM(internet)) AS totalCharges FROM t_charges');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCharges = $data['totalCharges'];
        return $totalCharges;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_charges ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
}