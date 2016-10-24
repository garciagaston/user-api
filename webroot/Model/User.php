<?php

require_once(dirname(__FILE__) . '/../Class/Database.php');

class User {
	
	public static function getUsers($id = null){
		$db = Database::getInstance();
	    $conn = $db->getConnection(); 
	    $sql = "SELECT * FROM users";
	    if ($id) {
	    	$sql .= ' WHERE id = '.$id;
	    }
	    $stmt = $conn->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public static function addUser($name, $picture, $address) {
		$id = null;
        $db = Database::getInstance();
	    $conn = $db->getConnection(); 
	    $sql = "INSERT INTO users (name, picture, address) VALUES ('{$name}', '{$picture}', '{$address}')";

	    try {
	    	$stmt = $conn->prepare($sql);
			$stmt->execute();
			$stmt->fetchAll(PDO::FETCH_ASSOC);
			$status = API_STATUS_SUCCESS;
			$id = $conn->lastInsertId();
		}catch (PDOException $e) {
            throw $e;
            $status = API_STATUS_FAIL;
		}
		return array('status' => $status, 'data' => array( 'id' => $id ) );
    }

    public static function updateUser($id, $name, $picture, $address) {
    	$row_modified = null;
        $db = Database::getInstance();
	    $conn = $db->getConnection(); 
	    $sql = "UPDATE users SET name = '{$name}', picture = '{$picture}', address = '{$address}' WHERE id = {$id}";
	    try {
		    $stmt = $conn->prepare($sql);
			$stmt->execute();
			$stmt->fetchAll(PDO::FETCH_ASSOC);
			$row_modified = $stmt->rowCount(); 
			$status = API_STATUS_SUCCESS;
		}catch (PDOException $e) {
            throw $e;
            $status = API_STATUS_FAIL;
		}
		return array('status' => $status, 'data' => array( 'row_modified' => $row_modified ));
    }

    public static function deleteUser($id) {
    	$row_deleted = null;
     	$db = Database::getInstance();
	    $conn = $db->getConnection(); 
	    $sql = "DELETE FROM users WHERE id = {$id}";
	    $status = API_STATUS_FAIL;
	    try {
		    $stmt = $conn->prepare($sql);
			$stmt->execute();
			$stmt->fetchAll(PDO::FETCH_ASSOC);
			$row_deleted = $stmt->rowCount();
			if ($row_deleted) {
				$status = API_STATUS_SUCCESS;
			} 
		}catch (PDOException $e) {
            throw $e;
		}
		return array('status' => $status, 'data' => array( 'row_deleted' => $row_deleted ));   
    }

}