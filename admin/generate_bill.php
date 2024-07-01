<?php 
    require_once('../Includes/config.php'); 
    require_once('../Includes/session.php');
    require_once('../Includes/admin.php');

    $aid = $_SESSION['aid'];
    //set dafaulted variables

    $query  = "SELECT curdate() AS bdate , adddate( curdate(),INTERVAL 30 DAY ) AS ddate , user.id AS uid , user.name AS uname FROM user ";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    
    $bdate = $row['bdate'];
    $ddate = $row['ddate'];


    // if (isset($_POST['bdate'])) {
    //     $bdate = $_POST['bdate'];
    // }
    // if (isset($_POST['ddate'])) {
    //     $ddate = $_POST['ddate'];    }
    if (isset($_POST['uid'])) {
        $uid = $_POST['uid'];
    }if (isset($_POST['units'])) {
        $units = $_POST['units']; 
		
		//echo $units;
    }if (isset($_POST['uname'])) {
        $uname = $_POST['uname']; 
    }

if (isset($_POST['usertype'])) {
        $usertype = $_POST['usertype']; 
    }
	
	if (isset($_POST['utility'])) {
        $utility = $_POST['utility']; 
    }

    if (isset($_POST['generate_bill'])) {
        if(isset($_POST["units"]) && !empty($_POST["units"]))
        {
// CONVERTING UNITS TO AMOUNT
            echo $usertype .''.$utility;
			
			$units=$_POST["units"];
			
			if($usertype=='Home' && $utility =='Electricity')
			{
				//echo $units1;
				
				 if($units >=0 && $cash <=300) $units1=$units*1;;
if($units >=301 && $units <=600)$units1=$units*3;
if($units >=601 && $units <=1250) $units1=$units*5;
if($units >=1251 && $units <=2500) $units1=$units*10;
				 
				  

			}
			
			
			else if($usertype=='Business' && $utility =='Electricity')
         
		 {
			 
			 
				if($units >=0 && $cash <=3000) $units1=$units*10;;
				if($units >=3001 && $units <=6000)$units1=$units*15;
				if($units >=6001 && $units <=12500) $units1=$units*20;
				if($units >=12501 && $units <=25000) $units1=$units*25;

		 }
		 
		 
		 
		 else if($usertype=='Home' && $utility =='Gas')
         
		 {
			 
			 
				 if($units >=0 && $cash <=300) $units1=$units*1;;
if($units >=301 && $units <=600)$units1=$units*3;
if($units >=601 && $units <=1250) $units1=$units*5;
if($units >=1251 && $units <=2500) $units1=$units*10;
				 
		 }
		 
		 
		  else if($usertype=='Home' && $utility =='Water')
         
		 {
			 
			 
				 if($units >=0 && $cash <=300) $units1=$units*1;;
if($units >=301 && $units <=600)$units1=$units*3;
if($units >=601 && $units <=1250) $units1=$units*5;
if($units >=1251 && $units <=2500) $units1=$units*10;
				 
		 }
		 
		 
		 else if($usertype=='Business' && $utility =='Gas')
         
		 {
			 
			 
				if($units >=0 && $cash <=3000) $units1=$units*10;;
				if($units >=3001 && $units <=6000)$units1=$units*15;
				if($units >=6001 && $units <=12500) $units1=$units*20;
				if($units >=12501 && $units <=25000) $units1=$units*25;

		 }
		 
		 
		 else if($usertype=='Business' && $utility =='Water')
         
		 {
			 
			 
				if($units >=0 && $cash <=3000) $units1=$units*1;;
				if($units >=3001 && $units <=6000)$units1=$units*15;
				if($units >=6001 && $units <=12500) $units1=$units*20;
				if($units >=12501 && $units <=25000) $units1=$units*25;

		 }
		 
		 
            echo $units1;
            $query1 = "call unitstoamount({$units} , @x)";
            $result1 = mysqli_query($con,$query1);  

// INSERTING VALUES INTO BILL
            $query  = " INSERT INTO bill (aid , uid , units , amount , status , bdate , ddate )";
            $query .= " VALUES ( {$aid} , {$uid} , {$units} , $units1, 'PENDING' , '{$bdate}' , '{$ddate}' )";
            $result2 = mysqli_query($con,$query);  
            if (!mysqli_query($con,$query1))
            {
                die('Error: ' . mysqli_error($con));
            }

// INSERTING VALUES INTO TRANSACTION            

            $query2 = "SELECT id , amount FROM bill WHERE aid={$aid} AND uid={$uid} AND units={$units} ";
            $query2 .= "AND status='PENDING'  AND bdate='{$bdate}' AND ddate='{$ddate}' ";

            $result3 =mysqli_query($con,$query2);
            if (!mysqli_query($con,$query2))
            {
                die('Error: ' . mysqli_error($con));
            } 

            $row = mysqli_fetch_row($result3);

            $bid = $row[0];$amount=$row[1];
            insert_into_transaction($bid,$amount);
            
        }  
    }
    header("Location:bill.php");
?>