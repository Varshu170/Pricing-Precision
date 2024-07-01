    <?php 
    include("../Includes/session.php");
    include("../Includes/config.php");
    
    $id=$_SESSION['uid'];
    $comp=$_POST["application"];
    $aid    = rand(1,2);
    $stat   ="NOT PROCESSED"; 
    
    if(isset($_POST["application"]) && !empty($_POST["application"]))
    {
        $query  = "INSERT INTO application(uid,aid,application,status)";
        $query .= " VALUES ({$id},{$aid},'{$comp}','NOT PROCESSED')";
        mysqli_query($con,$query);  
    }
    
    header("Location:experience.php");   
    ?>