<?php
class AffaireManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Affaire $affaire){
    	$query = $this->_db->prepare(' INSERT INTO t_affaire (
		numero, dateRdv, heureRdv, dateSortie, nature, prix, paye, nomClient, cinClient, telephoneClient, 
		mandataire, status, province, mp, cr, quartier, sousquartier, propriete, nomTopographe, 
		telephoneTopographe, montantTopographe, nomService, telephoneService, montantService, nomSource,
		telephoneSource, montantSource, created, createdBy)
		VALUES (:numero, :dateRdv, :heureRdv, :dateSortie, :nature, :prix, :paye, :nomClient, :cinClient, 
        :telephoneClient, :mandataire, :status, :province, :mp, :cr, :quartier, :sousquartier, :propriete, 
        :nomTopographe, :telephoneTopographe, :montantTopographe, :nomService, :telephoneService, :montantService, 
        :nomSource, :telephoneSource, :montantSource, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':numero', $affaire->numero());
		$query->bindValue(':dateRdv', $affaire->dateRdv());
		$query->bindValue(':heureRdv', $affaire->heureRdv());
		$query->bindValue(':dateSortie', $affaire->dateSortie());
		$query->bindValue(':nature', $affaire->nature());
		$query->bindValue(':prix', $affaire->prix());
		$query->bindValue(':paye', $affaire->paye());
        $query->bindValue(':nomClient', $affaire->nomClient());
        $query->bindValue(':cinClient', $affaire->cinClient());
        $query->bindValue(':telephoneClient', $affaire->telephoneClient());
		$query->bindValue(':mandataire', $affaire->mandataire());
		$query->bindValue(':status', $affaire->status());
		//$query->bindValue(':idTopographe', $affaire->idTopographe());
		//$query->bindValue(':idSource', $affaire->idSource());
		//$query->bindValue(':idService', $affaire->idService());
		//$query->bindValue(':idClient', $affaire->idClient());
		$query->bindValue(':province', $affaire->province());
		$query->bindValue(':mp', $affaire->mp());
		$query->bindValue(':cr', $affaire->cr());
		$query->bindValue(':quartier', $affaire->quartier());
		$query->bindValue(':sousquartier', $affaire->sousquartier());
		$query->bindValue(':propriete', $affaire->propriete());
        $query->bindValue(':nomTopographe', $affaire->nomTopographe());
        $query->bindValue(':telephoneTopographe', $affaire->telephoneTopographe());
		$query->bindValue(':montantTopographe', $affaire->montantTopographe());
        $query->bindValue(':nomService', $affaire->nomService());
        $query->bindValue(':telephoneService', $affaire->telephoneService());
		$query->bindValue(':montantService', $affaire->montantService());
        $query->bindValue(':nomSource', $affaire->nomSource());
        $query->bindValue(':telephoneSource', $affaire->telephoneSource());
		$query->bindValue(':montantSource', $affaire->montantSource());
		$query->bindValue(':created', $affaire->created());
		$query->bindValue(':createdBy', $affaire->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Affaire $affaire){
    	$query = $this->_db->prepare('UPDATE t_affaire SET 
		numero=:numero, dateRdv=:dateRdv, heureRdv=:heureRdv, dateSortie=:dateSortie, nature=:nature, prix=:prix, 
		paye=:paye, nomClient=:nomClient, cinClient=:cinClient, telephoneClient=:telephoneClient, 
		mandataire=:mandataire, status=:status, province=:province, mp=:mp, cr=:cr, quartier=:quartier, 
		sousquartier=:sousquartier, propriete=:propriete, nomTopographe=:nomTopographe, 
		montantTopographe=:montantTopographe, nomService=:nomService, montantService=:montantService, 
		nomSource=:nomSource, telephoneSource=:telephoneSource, montantSource=:montantSource, 
		updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $affaire->id());
        $query->bindValue(':numero', $affaire->numero());
		$query->bindValue(':dateRdv', $affaire->dateRdv());
		$query->bindValue(':heureRdv', $affaire->heureRdv());
		$query->bindValue(':dateSortie', $affaire->dateSortie());
		$query->bindValue(':nature', $affaire->nature());
		$query->bindValue(':prix', $affaire->prix());
		$query->bindValue(':paye', $affaire->paye());
        $query->bindValue(':nomClient', $affaire->nomClient());
        $query->bindValue(':cinClient', $affaire->cinClient());
        $query->bindValue(':telephoneClient', $affaire->telephoneClient());
		$query->bindValue(':mandataire', $affaire->mandataire());
		$query->bindValue(':status', $affaire->status());
		//$query->bindValue(':idTopographe', $affaire->idTopographe());
		//$query->bindValue(':idSource', $affaire->idSource());
		//$query->bindValue(':idService', $affaire->idService());
		//$query->bindValue(':idClient', $affaire->idClient());
		$query->bindValue(':province', $affaire->province());
		$query->bindValue(':mp', $affaire->mp());
		$query->bindValue(':cr', $affaire->cr());
		$query->bindValue(':quartier', $affaire->quartier());
		$query->bindValue(':sousquartier', $affaire->sousquartier());
		$query->bindValue(':propriete', $affaire->propriete());
		$query->bindValue(':nomTopographe', $affaire->nomTopographe());
        $query->bindValue(':montantTopographe', $affaire->montantTopographe());
        $query->bindValue(':nomService', $affaire->nomService());
        $query->bindValue(':montantService', $affaire->montantService());
        $query->bindValue(':nomSource', $affaire->nomSource());
        $query->bindValue(':telephoneSource', $affaire->telephoneSource());
        $query->bindValue(':montantSource', $affaire->montantSource());
		$query->bindValue(':updated', $affaire->updated());
		$query->bindValue(':updatedBy', $affaire->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_affaire
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getAffaireById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_affaire
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Affaire($data);
	}

	public function getAffaires(){
		$affaires = array();
		$query = $this->_db->query('SELECT * FROM t_affaire
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$affaires[] = new Affaire($data);
		}
		$query->closeCursor();
		return $affaires;
	}

	public function getAffairesByLimits($begin, $end){
		$affaires = array();
		$query = $this->_db->query('SELECT * FROM t_affaire
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$affaires[] = new Affaire($data);
		}
		$query->closeCursor();
		return $affaires;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_affaire
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
    
    /*************************************************
     *        New Methods
     **************************************************/
    
    public function getAffaireNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }
    
    public function getAffaireNumberMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire 
        WHERE MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    } 
     
    public function getAffaireNumberAnnulee(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire WHERE statut="annulee"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }
    
    public function getAffaireNumberAnnuleeMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire WHERE statut="annulee"
        AND MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }
    
    public function getAffaireNumberEnCours(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire WHERE statut="encours"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }

    public function getAffaireNumberEnCoursMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire WHERE statut="encours" 
        AND MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }

    public function getAffaireNumberArchivee(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire WHERE statut="archivee"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }
    
    public function getAffaireNumberArchiveeMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire WHERE statut="archivee"
        AND MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }
    
    public function getAffaireNumberTerminee(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire WHERE statut="terminee"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }
    
    public function getAffaireNumberTermineeMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS affaireNumbers FROM t_affaire WHERE statut="terminee"
        AND MONTHNAME(dateRdv) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['affaireNumbers'];
    }

    public function getAffairesGroupByMonth(){
        $affaires = array();
        $query = $this->_db->query(
        "SELECT * FROM t_affaire 
        GROUP BY MONTH(dateRdv), YEAR(dateRdv)
        ORDER BY dateRdv DESC");
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $affaires[] = new Affaire($data);
        }
        $query->closeCursor();
        return $affaires;
    }
    
    public function getAffairesByMonthYear($month, $year){
        $affaires = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_affaire 
        WHERE MONTH(dateRdv) = :month
        AND YEAR(dateRdv) = :year
        ORDER BY dateRdv DESC");
        $query->bindValue(':month', $month);
        $query->bindValue(':year', $year);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $affaires[] = new Affaire($data);
        }
        $query->closeCursor();
        return $affaires;
    }
    
    public function getTotalPaye(){
        $query = $this->_db->query('SELECT SUM(paye) AS totalPaye FROM t_affaire');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalPaye = $data['totalPaye'];
        return $totalPaye;
    }
    
    public function exists($numero){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_affaire WHERE REPLACE(numero, ' ', '') LIKE REPLACE(:numero, ' ', '') ");
        $query->execute(array(':numero' => $numero));
        return $query->fetchColumn();
    }
}