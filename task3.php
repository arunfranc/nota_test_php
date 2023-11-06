<?php

//Create TableCreator class
 class TableCreator
{
	//Constructor for TableCreator class
	public function __construct()
    {
        $tbl_exist = $this->tableExists('Test');
        if($tbl_exist != "exists"){
        	$this->create();
        }
        $this->fill();
    }


    //Create create method.Only access within the class
    private function create()
    {
        // Database connection 
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'test';
	    // Create a new PDO connection to the database
		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection failed: " . $e->getMessage());
		}

		// SQL code to create the Test table
        $query = "CREATE TABLE Test (
            id INT AUTO_INCREMENT PRIMARY KEY,
            script_name VARCHAR(25),
            start_time DATETIME,
            end_time DATETIME,
            result ENUM('normal', 'illegal', 'failed', 'success')
        )";
		$pdo->exec($query);

    }

    //Create table exist method for checking table is exist or not
    public function tableExists($tbl)
	{
		// Database connection 
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'test';
	    // Create a new PDO connection to the database
		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection failed: " . $e->getMessage());
		}

		//Show the table
	    $results = $pdo->query("SHOW TABLES LIKE '$tbl'");
	    if(!$results) {
	        die(print_r($pdo->errorInfo(), TRUE));
	    }

	    //Count greater than 0 it will return exists
	    if($results->rowCount()>0){return 'exists';}
	}

    //Create fill method.Only access within the class
    private function fill()
    {
    	//Call random data function
    	$data = $this->randomData();

    	// Database connection 
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'test';
	    // Create a new PDO connection to the database
		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection failed: " . $e->getMessage());
		}

    	// SQL code to insert data into the Test table
        $query = "INSERT INTO Test (script_name, start_time, end_time, result) VALUES (?, ?, ?, ?)";
        $pdo->prepare($query)->execute([$data['script_name'], $data['start_time'], $data['end_time'], $data['result']]);

    }

    //Generate random data for the Test table by randomData method.
    private function randomData()
    {
        return [
            'script_name' => 'task3',
            'start_time' => date('Y-m-d H:i:s', rand(0, time())),
            'end_time' => date('Y-m-d H:i:s', rand(0, time())),
            'result' => ['normal', 'illegal', 'failed', 'success'][rand(0, 3)],
        ];
    }

     public function get()
    {
    	// Database connection 
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'test';
    	// Create a new PDO connection to the database
		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection failed: " . $e->getMessage());
		}
        // SQL code to select data from the Test table 
        $query = "SELECT * FROM Test WHERE result IN ('normal', 'success')";
        return $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

}

//Create object and access the class data
$obj = new TableCreator();
$data = $obj->get();
print_r($data);
?>
