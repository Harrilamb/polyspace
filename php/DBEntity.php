
<?php

// Declaring an interface called Comparable 

interface Comparable {
	public function compareTo($other); 
}



class DBEntity implements Comparable {

	public $id, $parent_id, $title, $description, $tier, $username, $userid; 
	/**
	* Define a valid constructor 
	*/
	public function __construct($id, $parent_id, $title, $description, $tier, $username, $userid){
		if($tier === NULL){
			throw new Exception("Variable 'tier' must not be null"); 
		}
		$this->id = $id; 
		$this->parent_id = $parent_id; 
		$this->title = $title; 
		$this->description = $description; 
		$this->tier = $tier; 
		$this->username = $username;
		$this->userid = $userid; 
	}

	public static function fromJSON($json_obj){
		$id =  $json_obj["id"]; 
		$parent_id =  $json_obj["parentid"]; 
		$title = $json_obj["title"]; 
		$tier =  $json_obj["tier"]; 
		$description = $json_obj["description"]; 
		$username = $json_obj["owner"]; 
		$userid =  $json_obj["ownerid"]; 
		$dbEntry= new DBEntity((int)$id, (int)$parent_id, $title, $description, (int)$tier, $username, (int)$userid); 
		//var_dump($dbEntry); 
		return $dbEntry; 
	}

	/** 
	* Define method to implement the Comparable interface 
	*/
	public function compareTo($other){

		if( !($other instanceof DBEntity)){
			throw new Exception("$other not instanceof DBEntity"); 
		}
		return $this->tier - $other->tier; 


	}

}

class MinimumPriorityQueue {

	private $dbEntries =  array(); 
	private $numItems; 

	/**
	* Define default constructor
	*/
	public function __construct(){
		// push null at beggining for efficient implementation. 
		$this->dbEntries[] = NULL; 
		$this->numItems=0; 
	}


	/**
	* Define the enqueue method 
	*/
	public function enqueue($dbEntry){
	
		if(!($dbEntry instanceof Comparable)){
			$error = "dbEntry must be Comparable object\n"; 
			var_dump($error); 
			throw new Exception("$dbEntry must be Comparable object\n"); 
		} 
		$this->numItems++; 
		$this->dbEntries[] = $dbEntry;
		// we just added the root, so simply return. 
		if($this->numItems == 1){return;}
		
		// start at end of the list 
		$index = $this->numItems; 
		
		for(; $index > 1; $index = (int)($index/2)){

			$indexOfParent = (int)($index/2); 

			$parent =  $this->dbEntries[$indexOfParent]; 

			// if child less than parent, then swap
			if($dbEntry->compareTo($parent) < 0){
				$this->dbEntries[$indexOfParent] = $dbEntry; 
				$this->dbEntries[$index] = $parent; 
			}
		}
		return; 
	}

	/**
	* Define a method to deque items from the list. 
	*/
	public function dequeue(){
		if($this->numItems == 0){
			$error = "NoSuchElementExeption: queue does not have any items."; 
			var_dump($error); 
			throw new Exception("NoSuchElementExeption: queue does not have any items."); 
		}

		$root = $this->dbEntries[1]; 
		$lastItem = $this->dbEntries[$this->numItems]; 
		$this->dbEntries[1] = $lastItem; 
		// remove the last item. 
		unset($this->dbEntries[$this->numItems]); 
		$this->numItems--; 

		if($this->numItems == 0){return $root;}

		$indexOfLastParent = (int)($this->numItems/ 2); 

		$currentParent = 1; 
		for(; $currentParent <= $indexOfLastParent; $currentParent++){

			$indexOfLeftChild = $currentParent*2; 
			$leftChild = $this->dbEntries[$currentParent *2]; 

			$indexOfRigthChild = $currentParent*2 +1; 

			$smallestIndex = $indexOfLeftChild; 

			// if the tree has a right child 
			if($indexOfRigthChild <= $this->numItems){

				$smallestIndex = ( ($leftChild->compareTo($this->dbEntries[$indexOfRigthChild]) < 0) ?   $indexOfLeftChild: $indexOfRigthChild); 
			}

			// compare the parent with the smallest child 
			if($this->dbEntries[$smallestIndex]->compareTo($this->dbEntries[$currentParent]) < 0){
				// swap child and parent 
				$temp = $this->dbEntries[$smallestIndex]; 
				$this->dbEntries[$smallestIndex] = $this->dbEntries[$currentParent]; 
				$this->dbEntries[$currentParent] = $temp; 
			}
		}

		return $root; 
	}

	public function size(){
		return $this->numItems; 
	}

}

function instantiate($data){
	$filename = "systems.json"; 
	$json_data = json_decode($data, true); 

	$dbEntries = array();

	foreach ($json_data as $json_obj) { 
		$dbEntries[] = DBEntity::fromJSON($json_obj); 
	}
	$queue = new MinimumPriorityQueue(); 
	
	

	foreach ($dbEntries as $entry) {
		// put each item. 
		$queue->enqueue($entry); 
		//Didn't work, maybe version of php. Look into reimplementing
		/*
		try{
			//var_dump($entry); 
			$Queue->enqueue($entry); 
		}
		catch(Exception $error){
			//var_dump($entry); 
			print($error->getMessage());
		}*/
	
	}

	$sortedList =  array(); 

	while($queue->size() > 0){
		$item = $queue->dequeue();
		$sortedList[] = $item; 
	}

	//var_dump($sortedList); 
	return json_encode($sortedList); 
}
?>