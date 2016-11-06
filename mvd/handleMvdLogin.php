<?php
	/* Get the connection to database(PDO Method) Store in $connn var */
	/*-----------------------------------------------------------------*/
		require_once('connection.php');
	/*-----------------------------------------------------------------*/

	if(isset($_POST['uemail']) && isset($_POST['upass'])){
		//Trim Function Removes Whitespace from both ends of the string
				$uemail = trim($_POST['uemail']);
				$upass  = trim($_POST['upass']);


		/* Sanitization and validation Functions */

			if($uemail =="" || $upass=="" ){
				$error[] = "One or Many Required Parameters are missing !";
			}
			else{

				//Filter_Var is a builtin PHP function takes two pieces of data Var to check and the type
				//Sanitizing
				$uemail = filter_var($uemail,FILTER_SANITIZE_EMAIL);
				//Validating
				 if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)) {
		            $error[] = "$uemail is <strong>NOT</strong> a valid email address.<br/><br/>";
		        }
			}
		/* Data Sanitization and validation Complete */

		/* Inserting values into database */
		if(empty($error)){
			if($mvd->login($uemail,$upass))
            	{
									session_start();
									$_SESSION['mvdemail'] = $uemail;
									$mvd->redirect('MVDQuery.php');
            	}
              else{
            	$mvd->redirect('error.html');
            }
        }
        else{
        	foreach($error as $error){
        		echo $error;
        	}
        }
       }

?>
