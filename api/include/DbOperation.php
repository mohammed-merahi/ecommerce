<?php

class DbOperation
{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }
	
	/************************************************categories********************************************************************/
    public function createCategorie($categorie,$color,$commentaire){
		$sql = "INSERT INTO categories(categorie,color,commentaire) values(?, ?, ?)";
		$stmt = $this->con->prepare( $sql );
				
		$stmt->bind_param("sis", $categorie, $color, $commentaire);
		$result = $stmt->execute();
		$stmt->close();
		if ($result) {
			return 0;
		}
		return 1;

    }
	
    public function getAllCategories(){
        $stmt = $this->con->prepare("SELECT * FROM categories");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res;
    }
	
    public function getCategorie($id){
        $stmt = $this->con->prepare("SELECT * FROM categories WHERE categorie=?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	
    public function updateCategorie($oldcateg,$newcateg,$color,$commentaire){
        $stmt = $this->con->prepare("UPDATE categories SET categorie=?, color=?,commentaire=? WHERE categorie=?");
        $stmt->bind_param("siss",$newcateg,$color,$commentaire,$oldcateg);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }
	
	public function deleteCategorie($id){
        $stmt = $this->con->prepare("DELETE FROM categories WHERE categorie=?");
        $stmt->bind_param("s",$id);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }
	/******************************************************************************************************************************/
	
	/*******************************************************myphotos***************************************************************/
	public function createMyphoto($code, $photo, $photo2, $extention){
		$sql = "INSERT INTO myphotos(code,photo,photo2,extention) values(?, ?, ?, ?)";
		$stmt = $this->con->prepare( $sql );
		
		$stmt->bind_param("ssss", $code, $photo, $photo2, $extention);
		$result = $stmt->execute();
		$stmt->close();
		if ($result) {
			return 0;
		}
		return 1;

    }
	
    public function getAllMyphotos(){
        $stmt = $this->con->prepare("SELECT * FROM myphotos");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res;
    }

    public function getMyphoto($id){
        $stmt = $this->con->prepare("SELECT * FROM myphotos WHERE code=?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	
    public function updateMyphoto($oldcode,$newcode,$photo, $photo2, $extention){
        $stmt = $this->con->prepare("UPDATE myphotos SET code=?, photo=?,photo2=?,extention=? WHERE code=?");
        $stmt->bind_param("sssss",$newcode,$photo, $photo2, $extention,$oldcode);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }
	
	public function deleteMyphoto($id){
        $stmt = $this->con->prepare("DELETE FROM myphotos WHERE code=?");
        $stmt->bind_param("s",$id);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }
	/**************************************************fam_articles*******************************************************************/
    public function createFamArticle( $famille,$libelle,$parent,$tva,$codeart,$codetaxe,$marge1,$marge2,$marge3,$marge4,$marge5,$ct,$color,$printer ){
		$sql = "INSERT INTO fam_articles( famille,libelle,parent,tva,codeart,codetaxe,marge1,marge2,marge3,marge4,marge5,ct,color,printer ) 
								values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $this->con->prepare( $sql );
		
		$stmt->bind_param("sssdssdddddiis", $famille,$libelle,$parent,$tva,$codeart,$codetaxe,$marge1,$marge2,$marge3,$marge4,$marge5,$ct,$color,$printer);
		$result = $stmt->execute();
		$stmt->close();
		if ($result) {
			return 0;
		}
		return 1;

    }
	
	public function getAllFam_Articles(){
        $stmt = $this->con->prepare("SELECT * FROM fam_articles");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res;
    }
	
	public function getFamArticle($id){
        $stmt = $this->con->prepare("SELECT * FROM fam_articles WHERE famille=?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	
	public function updateFamArticle($oldfamille,$newfamille,$libelle,$parent,$tva,$codeart,$codetaxe,$marge1,$marge2,$marge3,$marge4,$marge5,$ct,$color,$printer){
        $stmt = $this->con->prepare("UPDATE fam_articles SET famille=?, libelle=?,parent=?,tva=?,codeart=?,codetaxe=?,
										marge1=?,marge2=?,marge3=?,marge4=?,marge5=?,ct=?,color=?,printer=?	
										WHERE famille=?");
        $stmt->bind_param("sssdssdddddiiss", $newfamille,$libelle,$parent,$tva,$codeart,$codetaxe,$marge1,$marge2,$marge3,$marge4,$marge5,$ct,$color,$printer,$oldfamille);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }
	
	public function deleteFamArticle($id){
        $stmt = $this->con->prepare("DELETE FROM fam_articles WHERE famille=?");
        $stmt->bind_param("s",$id);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }
	/***********************************************Marques************************************************************************/
	public function createMarque($marque,$commentaire){
		$sql = "INSERT INTO marques(marque,commentaire) values(?, ?)";
		$stmt = $this->con->prepare( $sql );
				
		$stmt->bind_param("ss", $marque, $commentaire);
		$result = $stmt->execute();
		$stmt->close();
		if ($result) {
			return 0;
		}
		return 1;

    }
	
    public function getAllMarques(){
        $stmt = $this->con->prepare("SELECT * FROM marques");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res;
    }
	
    public function getMarque($id){
        $stmt = $this->con->prepare("SELECT * FROM marques WHERE marque=?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $marques = $stmt->get_result();
        $stmt->close();
        return $marques;
    }
	
    public function updateMarque($oldmarque,$newmarque,$commentaire){
        $stmt = $this->con->prepare("UPDATE marques SET marque=?, commentaire=? WHERE marque=?");
        $stmt->bind_param("sss",$newmarque,$commentaire,$oldmarque);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }
	
	public function deleteMarque($id){
        $stmt = $this->con->prepare("DELETE FROM marques WHERE marque=?");
        $stmt->bind_param("s",$id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
	/*******************************************************Mylogo*****************************************************************/
	public function createMylogo($id, $photo, $extention){
		$sql = "INSERT INTO mylogo(id,photo,extention) values(?, ?, ?)";
		$stmt = $this->con->prepare( $sql );
				
		$stmt->bind_param("iss", $id, $photo, $extention);
		$result = $stmt->execute();
		$stmt->close();
		if ($result) {
			return 0;
		}
		return 1;

    }
	
    public function getAllMylogos(){
        $stmt = $this->con->prepare("SELECT * FROM mylogo");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res;
    }
	
    public function getMylogo($id){
        $stmt = $this->con->prepare("SELECT * FROM mylogo WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $marques = $stmt->get_result();
        $stmt->close();
        return $marques;
    }
	
    public function updateMylogo($id,$photo,$extention){
        $stmt = $this->con->prepare("UPDATE mylogo SET photo=?, extention=? WHERE id=?");
        $stmt->bind_param("ssi",$photo,$extention,$id);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }
	
	public function deleteMylogo($id){
        $stmt = $this->con->prepare("DELETE FROM mylogo WHERE id=?");
        $stmt->bind_param("s",$id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
	/******************************************************************************************************************************/
	/******************************************************************************************************************************/
	/******************************************************************************************************************************/
	/******************************************************************************************************************************/
	

    //Checking the Admin is valid or not by api key
    public function isValidAdmin($api_key){
        $stmt = $this->con->prepare("SELECT * from rest WHERE api_key=?");
        $stmt->bind_param("s",$api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows>0;
    }


    //Method to generate a unique api key every time
    private function generateApiKey(){
        return md5(uniqid(rand(), true));
    }
}