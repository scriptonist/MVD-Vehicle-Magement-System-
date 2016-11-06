<?php
	/* Get the connection to database(PDO Method) Store in $connn var */
	/*-----------------------------------------------------------------*/
		require_once('connection.php');
	/*-----------------------------------------------------------------*/

	if(isset($_POST['uemail']) && isset($_POST['ufname']) && isset($_POST['ulname']) && isset($_POST['upass'])){
		//Trim Function Removes Whitespace from both ends of the string
				$uemail = trim($_POST['uemail']);
				$ufname = trim($_POST['ufname']);
				$ulname = trim($_POST['ulname']);
				$upass  = trim($_POST['upass']);
				$uconfpass  = trim($_POST['uconfpass']);


		/* Sanitization and validation Functions */

			if($uemail =="" || $ufname == "" || $ulname == "" || $upass=="" || $uconfpass == "" ){
				$error[] = "One or Many Required Parameters are missing !";
			}
			else{

				//Filter_Var is a builtin PHP function takes two pieces of data Var to check and the type
				//Sanitizing
				$uemail = filter_var($uemail,FILTER_SANITIZE_EMAIL);
				$ufname = filter_var($ufname,FILTER_SANITIZE_STRING);
				$ulname = filter_var($ulname,FILTER_SANITIZE_STRING);


				if($uconfpass != $upass || (strlen($uconfpass) < 8 && strlen($upass) < 8) ){
				$error[] = "Passwords Doesn't Match / Password Criterias not followed!";
				}
			}
		/* Data Sanitization and validation Complete */

		/* Inserting values into database */
		if(empty($error)){
			if($user->register($uemail,$ufname,$ulname,$upass))
            	{
                	$user->redirect('RegSuc.php');
            	}
        }
        else{
        	foreach($error as $error){
        		echo $error;
        	}
        }
       }
?>
