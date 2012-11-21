<?php
$fname = $_POST['tfFname'];
$lname = $_POST['tfLname'];

echo checkInput($fname, $lname);

function checkInput($fname, $lname) {
  $retVal = "You have registered with the name " . $fname . " " . $lname . " successfully.";
  
  $isOK = true;
  for ($i = 1; $i <= strlen($fname); $i++)
    if (!ctype_lower($fname[$i])) {
      $isOK = false;
      break;
    }

  for ($i = 1; $i <= strlen($lname); $i++)
    if (!ctype_lower($lname[$i])) {
      $isOK = false;
      break;
    }

  if (!ctype_upper($fname[0]) || !ctype_upper($lname[0]))
    $retVal = "Error: The first letter of the first and last name must be capitalized.";
  if (!$isOK)
    $retVal = "Error: All letters after the first letter of the first and last name must be lower case.";
  
  return $retVal;
}
?>