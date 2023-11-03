// Define the folder path
$folder = "/datafiles";

// Define the regex pattern to match file names
$expression = '/^[A-Za-z0-9]+\.ixt$/';

// Initialize an array to store matching file names
$files = array();

// Open the folder and read its contents
$open_folder = opendir($folder);
$entry = readdir($open_folder);
if ($open_folder) {
    while ($entry !== false) {
        // Check if the entry is a file and matches the pattern
        if (is_file("$folder/$entry") && preg_match($expression, $entry)) {
            $files[] = $entry;
        }
    }
    closedir($open_folder);
}

// Sort the matching file names alphabetically
sort($files);

// Display the sorted file names
echo "Matching files:\n";
foreach ($files as $file) {
    echo "$file\n";
}
