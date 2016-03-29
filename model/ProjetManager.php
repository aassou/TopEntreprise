<?php
class ProjetManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Projet $projet){
        $query = $this->_db->prepare('INSERT INTO t_projet (leve, dateCreation, dateFin, nom, type, objet,
		prix, paye, architecte, statut, titre, ilot, lot, idClient)
        VALUES (:leve, :dateCreation, :dateFin, :nom, :type, :objet, :prix, :paye, :architecte, 
        :statut, :titre, :ilot, :lot, :idClient)') 
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':leve', $projet->leve());
        $query->bindValue(':dateCreation', $projet->dateCreation());
		$query->bindValue(':dateFin', $projet->dateFin());
        $query->bindValue(':nom', $projet->nom());
		$query->bindValue(':type', $projet->type());
		$query->bindValue(':objet', $projet->objet());
		$query->bindValue(':prix', $projet->prix());
		$query->bindValue(':paye', $projet->paye());
		$query->bindValue(':architecte', $projet->architecte());
		$query->bindValue(':statut', $projet->statut());
		$query->bindValue(':titre', $projet->titre());
		$query->bindValue(':ilot', $projet->ilot());
		$query->bindValue(':lot', $projet->lot());
		$query->bindValue(':idClient', $projet->idClient());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Projet $projet){
		$query = $this->_db->prepare('UPDATE t_projet SET leve=:leve, dateCreation=:dateCreation, 
		dateFin=:dateFin, nom=:nom, type=:type, objet=:objet, prix=:prix, paye=:paye, architecte=:architecte, 
		statut=:statut, titre=:titre, ilot=:ilot, lot=:lot, idClient=:idClient WHERE id=:idProjet') 
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':leve', $projet->leve());
        $query->bindValue(':dateCreation', $projet->dateCreation());
		$query->bindValue(':dateFin', $projet->dateFin());
        $query->bindValue(':nom', $projet->nom());
		$query->bindValue(':type', $projet->type());
		$query->bindValue(':objet', $projet->objet());
		$query->bindValue(':prix', $projet->prix());
		$query->bindValue(':paye', $projet->paye());
		$query->bindValue(':architecte', $projet->architecte());
		$query->bindValue(':statut', $projet->statut());
		$query->bindValue(':titre', $projet->titre());
		$query->bindValue(':ilot', $projet->ilot());
		$query->bindValue(':lot', $projet->lot());
		$query->bindValue(':idClient', $projet->idClient());
		$query->bindValue(':idProjet', $projet->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idProjet){
		$query = $this->_db->prepare('DELETE FROM t_projet WHERE id=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getProjetNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS projetNumbers FROM t_projet');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['projetNumbers'];
    }
    
    public function getProjetById($idProjet){
        $query = $this->_db->prepare('SELECT * FROM t_projet WHERE id=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Projet($data);
    }
    
    public function getProjets(){
        $projets = array();
        $query = $this->_db->query('SELECT * FROM t_projet ORDER BY dateCreation ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $projets[] = new Projet($data);
        }
        $query->closeCursor();
        return $projets;
    }
	
	public function getProjetsByLimits($begin, $end){
        $projets = array();
        $query = $this->_db->query('SELECT * FROM t_projet ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $projets[] = new Projet($data);
        }
        $query->closeCursor();
        return $projets;
    }
	
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_projet ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($idProjet){
		$query = $this->_db->prepare('SELECT COUNT(*) FROM t_projet WHERE id=:idProjet');
		$query->execute(array(':idProjet' => $idProjet));
		//get result
		return (bool) $query->fetchColumn();
	}
	
}