<?php
class RendezVousManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(RendezVous $rendezVous){
        $query = $this->_db->prepare('INSERT INTO t_rendez_vous (nomClient, cin, telefonClient, source, telefonSource,
        dateRdv, heureRdv, nature, prix, mandataire, statut, province, mp, cr, quartier)
        VALUES (:nomClient, :cin, :telefonClient, :source, :telefonSource, :dateRdv, :heureRdv, 
		:nature, :prix, :mandataire, :statut, :province, :mp, :cr, :quartier)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nomClient', $rendezVous->nomClient());
		$query->bindValue(':cin', $rendezVous->cin());
		$query->bindValue(':telefonClient', $rendezVous->telefonClient());
		$query->bindValue(':source', $rendezVous->source());
		$query->bindValue(':telefonSource', $rendezVous->telefonSource());
        $query->bindValue(':dateRdv', $rendezVous->dateRdv());
		$query->bindValue(':heureRdv', $rendezVous->heureRdv());
		$query->bindValue(':nature', $rendezVous->nature());
		$query->bindValue(':prix', $rendezVous->prix());
		$query->bindValue(':mandataire', $rendezVous->mandataire());
		$query->bindValue(':statut', $rendezVous->statut());
		$query->bindValue(':province', $rendezVous->province());
		$query->bindValue(':mp', $rendezVous->mp());
		$query->bindValue(':cr', $rendezVous->cr());
		$query->bindValue(':quartier', $rendezVous->quartier());
        $query->execute();
        $query->closeCursor();
    }
		
	public function update(RendezVous $rendezVous){
		$query = $this->_db->prepare('UPDATE t_rendez_vous SET nomClient=:nomClient, cin=:cin, telefonClient=:telefonClient, 
		source=:source, telefonSource=:telefonSource, dateRdv=:dateRdv, heureRdv=:heureRdv, nature=:nature, 
	  	prix=:prix, mandataire=:mandataire, statut=:statut, province=:province, mp=:mp, cr=:cr,
	  	quartier=:quartier WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $rendezVous->id());
		$query->bindValue(':nomClient', $rendezVous->nomClient());
		$query->bindValue(':cin', $rendezVous->cin());
		$query->bindValue(':telefonClient', $rendezVous->telefonClient());
		$query->bindValue(':source', $rendezVous->source());
		$query->bindValue(':telefonSource', $rendezVous->telefonSource());
		$query->bindValue(':dateRdv', $rendezVous->dateRdv());
		$query->bindValue(':heureRdv', $rendezVous->heureRdv());
		$query->bindValue(':nature', $rendezVous->nature());
		$query->bindValue(':prix', $rendezVous->prix());
		$query->bindValue(':mandataire', $rendezVous->mandataire());
		$query->bindValue(':statut', $rendezVous->statut());
		$query->bindValue(':province', $rendezVous->province());
		$query->bindValue(':mp', $rendezVous->mp());
		$query->bindValue(':cr', $rendezVous->cr());
		$query->bindValue(':quartier', $rendezVous->quartier());
        $query->execute();
        $query->closeCursor();
	}

	public function delete($idRendezVous){
		$query = $this->_db->prepare('DELETE FROM t_rendez_vous WHERE id=:idRendezVous');
		$query->bindValue(':idRendezVous', $idRendezVous);
		$query->execute();
		$query->closeCursor();
	}
    
	public function terminerRendezVous($idRendezVous){
		$query = $this->_db->prepare('UPDATE t_rendez_vous SET statut="terminee" 
		WHERE id=:idRendezVous') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idRendezVous', $idRendezVous);
		$query->execute();
        $query->closeCursor();
	}
	
	public function annulerRendezVous($idRendezVous){
		$query = $this->_db->prepare('UPDATE t_rendez_vous SET statut="annulee" 
		WHERE id=:idRendezVous') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idRendezVous', $idRendezVous);
		$query->execute();
        $query->closeCursor();
	}
	
    public function getRendezVousNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS rendezVousNumbers FROM t_rendez_vous');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['rendezVousNumbers'];
    }
	
	public function getRendezVousNumberAnnulee(){
        $query = $this->_db->query('SELECT COUNT(*) AS rendezVousNumbers FROM t_rendez_vous WHERE statut="annulee"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['rendezVousNumbers'];
    }
	
	public function getRendezVousNumberAnnuleeMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS rendezVousNumbers FROM t_rendez_vous WHERE statut="annulee"
        AND MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['rendezVousNumbers'];
    }
	
	public function getRendezVousNumberTermineeMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS rendezVousNumbers FROM t_rendez_vous WHERE statut="terminee"
        AND MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['rendezVousNumbers'];
    }
	
	public function getRendezVousNumberEnCours(){
        $query = $this->_db->query('SELECT COUNT(*) AS rendezVousNumbers FROM t_rendez_vous WHERE statut="encours"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['rendezVousNumbers'];
    }

	public function getRendezVousNumberMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS rendezVousNumbers FROM t_rendez_vous 
        WHERE MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['rendezVousNumbers'];
    }

	public function getRendezVousNumberEnCoursMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS rendezVousNumbers FROM t_rendez_vous WHERE statut="encours" 
        AND MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['rendezVousNumbers'];
    }

    public function getRendezVousById($idRendezVous){
        $query = $this->_db->prepare('SELECT * FROM t_rendez_vous WHERE id=:idRendezVous');
		$query->bindValue(':idRendezVous', $idRendezVous);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new RendezVous($data);
    }
    
	public function getRendezVousEnCours(){
        $rendezVous = array();
        $query = $this->_db->query('SELECT * FROM t_rendez_vous WHERE statut="encours" ORDER BY dateRdv DESC, heureRdv DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $rendezVous[] = new RendezVous($data);
        }
        $query->closeCursor();
        return $rendezVous;
    }
	
    public function getRendezVous(){
        $rendezVous = array();
        $query = $this->_db->query('SELECT * FROM t_rendez_vous WHERE statut<>"annulee" ORDER BY dateRdv DESC, heureRdv DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $rendezVous[] = new RendezVous($data);
        }
        $query->closeCursor();
        return $rendezVous;
    }
	
	public function getRendezVousByLimits($begin, $end){
        $rendezVous = array();
        $query = $this->_db->query('SELECT * FROM t_rendez_vous ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $rendezVous[] = new RendezVous($data);
        }
        $query->closeCursor();
        return $rendezVous;
    }
	
	public function getRendezVousEnCoursByLimits($begin, $end){
        $rendezVous = array();
        $query = $this->_db->query('SELECT * FROM t_rendez_vous WHERE statut="encours" ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $rendezVous[] = new RendezVous($data);
        }
        $query->closeCursor();
        return $rendezVous;
    }

	public function getRendezVousAnnuleByLimits($begin, $end){
        $rendezVous = array();
        $query = $this->_db->query('SELECT * FROM t_rendez_vous WHERE statut="annule" ORDER BY statut DESC '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $rendezVous[] = new RendezVous($data);
        }
        $query->closeCursor();
        return $rendezVous;
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_rendez_vous ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
}