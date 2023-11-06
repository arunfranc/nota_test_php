<?php

// Function to save data to the database
function save_to_database($data) {
    $date_created = date("Y-m-d H:i:s");
    
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

	//Inserting data
    $stmt = $pdo->prepare("INSERT INTO wiki_sections (date_created, title, url, picture, abstract) VALUES ('".$date_created."', :title, :url, :picture, :abstract)");
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':url', $data['links']);
    $stmt->bindParam(':picture', $data['pictures']);
    $stmt->bindParam(':abstract', $data['abstracts']);
    $stmt->execute();
}

// Function to download a web page
function download_page($url) {
    $page_content = file_get_contents($url);
    return $page_content;
}

$url = "https://www.wikipedia.org/";
$page_content = download_page($url);

if ($page_content) {
	//Crete document object model of the page content
    $doc = new DOMDocument();
    $doc->loadHTML($page_content);

    $xpath = new DOMXpath($doc);

    //Get the headings of the div tag
	$title = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' other-project-title ')]");
    for ($i = $title->length - 1; $i > -1; $i--) {
        $result['title'][] = $title->item($i)->firstChild->nodeValue;
    }

    //Get the abstracts of the div tag
    $abstracts = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' other-project-tagline ')]");
    for ($i = $abstracts->length - 1; $i > -1; $i--) {
        $result['abstracts'][] = $abstracts->item($i)->firstChild->nodeValue;
    }

    //Get the pictures classes of the div tag
    $pictures = $xpath->query(".//div[@class='other-project-icon']//div/@class");
    $classNames_array = array();
	foreach ($pictures as $target) {
	    $result['pictures'][] = $target->textContent;
	}
	
	//Get the urls of the div tag
    $links = $doc->getElementsByTagName("a");
    $i=0;
    foreach($links as $link) {
    if ($link->getAttribute('class') == "other-project-link") {
        $result['links'][] = $link->getAttribute('href');
    }
    $i++;
	}

    // echo "<pre>";
    // print_r($result);
    // exit();
	//Arrange the array data for inserting
    $item_1 = [];
	$item_2 = [];$item_3 = [];$item_4 = [];$item_5 = [];$item_6 = [];$item_7 = [];$item_8 = [];$item_9 = [];$item_10 = [];$item_11 = [];$item_12 = [];
	foreach ($result as $k => $v){
	    $item_1[$k] = $v[0];
	    $item_2[$k] = $v[1];
	    $item_3[$k] = $v[2];
	    $item_4[$k] = $v[3];
	    $item_5[$k] = $v[4];
	    $item_6[$k] = $v[5];
	    $item_7[$k] = $v[6];
	    $item_8[$k] = $v[7];
	    $item_9[$k] = $v[8];
	    $item_10[$k] = $v[9];
	    $item_11[$k] = $v[10];
	    $item_12[$k] = $v[11];
	}

	//Call database insert function to insert the data	
    save_to_database($item_1);
    save_to_database($item_2);
    save_to_database($item_3);
    save_to_database($item_4);
    save_to_database($item_5);
    save_to_database($item_6);
    save_to_database($item_7);
    save_to_database($item_8);
    save_to_database($item_9);
    save_to_database($item_10);
    save_to_database($item_11);
    save_to_database($item_12);

    
} else {
    echo "Failed to download the page.";
}



?>
