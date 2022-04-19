<?php
wp_head();
?>
<pre>
<?php

var_dump(base_wpGetMenuArray("test"));
base_getUF();
?>

<?php

// $file is the CSV file with the values
$file = "users.csv";
if (($handle = fopen($file, "r")) !== FALSE) {
	echo "<br> Et. 1 ";


	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		echo "<br> Et. 2 ";
		if (count($data)>1) {
			wdm_create_user($data[0], $data[1]);
		}
	}

    fclose($handle);
}


/* csv user importer */
function wdm_validate_csv($csv_file)
{
    $requiredHeaders = array('Username', 'Email');
    $firstLine = fgets($csv_file); //get first line of the CSV file
    $fileHeader = str_getcsv(trim($firstLine), ',', "'"); //parse the contents to an array

    //check the headers of the file
    if ($foundHeaders !== $requiredHeaders) {
      // report an error
      return false;
    }

    return true;
}

// create the user
function wdm_create_user($uname, $email)
{
    $user = array(
      'user_login' => $uname,
      'user_pass' => 'abc@123',
      'user_email' => $email
    );

    // check if user exists
    if (username_exists($uname)) {
      // update user or do nothing
    } else {
      // create new user
      $user_id = wp_insert_user($user);
    }
}

?>


<hr>

<?php
wp_footer();
?>


