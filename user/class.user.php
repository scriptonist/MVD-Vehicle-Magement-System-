<?php
class USER
{
    private $db;

    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }

    public function register($uemail,$ufname,$ulname,$upass)
    {
       try
       {
           $new_password = sha1(md5($upass));

           $stmt = $this->db->prepare("INSERT INTO users(email,fname,lname,password)
                                                       VALUES(:uemail,:ufname, :ulname, :upass");

           $stmt->bindparam(":ufname", $ufname);
           $stmt->bindparam(":ulname", $ulname);
           $stmt->bindparam(":uemail", $uemail);
           $stmt->bindparam(":upass", $new_password  );
           $stmt->execute();

           return $stmt;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
    }
    public function registerVehicle($owner,$vnumber,$rcpath,$rcfrom,$rctill,$insurancepath,$infrom,$intill)
    {

       try
       {
        $stmt = $this->db->prepare("INSERT INTO vehicles (owner,vehicleNumber,rcbook,rcfrom,rctill,insurance,insurancefrom,insurancetill,sdate)
                                                       VALUES(:owner,:vnumber,:rcpath,'$rcfrom','$rctill',:insurancepath,'$infrom','$intill',curdate())");

           $stmt->bindparam(":owner", $owner);
           $stmt->bindparam(":vnumber", $vnumber);
           $stmt->bindparam(":rcpath", $rcpath);

           $stmt->bindparam(":insurancepath", $insurancepath);

           $stmt->execute();

           return $stmt;
       }
       catch(PDOException $e)
       {
           header("Location:registeredError.html");
       }
    }
    public function update($uemail,$ufname,$ulname,$phone)
    {
       try
       {

           $stmt = $this->db->prepare("update users set fname=:ufname,lname=:ulname,phone=:phone
                                                       where email=:uemail");

           $stmt->bindparam(":ufname", $ufname);
           $stmt->bindparam(":ulname", $ulname);
           $stmt->bindparam(":uemail", $uemail);
           $stmt->bindparam(":phone", $phone );
           $stmt->execute();

           return $stmt;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
    }
    public function deleteVehicle($vehiclenumber){
      try
      {
         $stmt = $this->db->prepare("DELETE FROM vehicles WHERE vehicleNumber=:no ");
         $stmt->execute(array(':no'=>$vehiclenumber));

         if($stmt->rowCount() > 0)
         {
           return true;
         }
         else{
           return false;
         }
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
    }

    public function login($uemail,$upass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:uemail LIMIT 1");
          $stmt->execute(array(':uemail'=>$uemail));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
            $new_password = sha1(md5($upass));
             if( $new_password == $userRow['password'])
             {
                session_start();
                $_SESSION['userEmail'] = $userRow['email'];
                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
   public function getVehicles($uemail)
   {
      try
      {
         $stmt = $this->db->prepare("SELECT * FROM vehicles WHERE owner=:uemail");
         $stmt->execute(array(':uemail'=>$uemail));
        $out = '';
        $counter=1;
         while($userRow=$stmt->fetch(PDO::FETCH_ASSOC)){
           $out .= "<h3 class='bg-info'>Vehicle $counter</h3>";
           $rcpath = $userRow['rcbook'];
           $inpath = $userRow['insurance'];
           $rctill = $userRow['rctill'];
           $intill = $userRow['insurancetill'];
           $rc=strtotime($rctill);
           $rcrem=ceil(($rc-time())/60/60/24);
           $in=strtotime($intill);
           $inrem=ceil(($in-time())/60/60/24);
           if($rcrem < 0){
             $rcrem = '&nbsp &nbsp <span class="text-danger">Expired</span>';
           }
           else{
             $rcrem = '&nbsp &nbsp <span class="text-success">'.$rcrem.' Days Of Validity Remaining</span>';

           }
           if($inrem < 0){
             $inrem = '&nbsp &nbsp <span class="text-danger">Expired</span>';
           }
           else{
             $inrem = '&nbsp &nbsp <span class="text-success">'.$inrem.' Days Of Validity Remaining</span>';
           }
           $out .="<table class='table table-hover'>
           <tr>
              <td>
                Number
              </td>
              <td>".
                $userRow['vehicleNumber']
              ."</td>
              </tr>
              <tr>
                 <td>
                   RC Book
                 </td>
                 <td >".
                   "<a class='btn btn-default'id='rcbtn' target='_blank' href='$rcpath'>view</a>
                   ".$rcrem."
                 </td>

                 </tr><tr>
                    <td>
                      Insurance
                    </td>
                    <td>".
                      "<a class='btn btn-default'  target='_blank' href='$inpath'>view</a>
                      ".$inrem."
                    </td>
                    </tr>
           </table>";
           $counter++;
         }
         $out = Array($out,$counter);
         return $out;

      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
  }
   public function checkProfileExists($userEmail){
     try
     {
        $stmt = $this->db->prepare("SELECT profilePhoto FROM users WHERE email=:uemail LIMIT 1");
        $stmt->execute(array(':uemail'=>$userEmail));
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0)
        {
           if( $userRow['profilePhoto'] =='')
           {
              return false;
           }
           else
           {
              return true;
           }
        }
     }
     catch(PDOException $e)
     {
         echo $e->getMessage();
     }
   }
   public function UploadProfilePic($filename)
   {
      if(isset($_SESSION['userEmail']))
      {
        try
        {
          $stmt = $this->db->prepare("UPDATE users set profilephoto=:photo where email=:email");

          $stmt->bindparam(":photo", $filename);
          $stmt->bindparam(":email", $_SESSION['userEmail']);
          $stmt->execute();

          return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
      }
   }


   public function is_loggedin()
   {
      if(isset($_SESSION['userEmail']))
      {
         return true;
      }
   }

   public function redirect($url)
   {
       header("Location: $url");
   }

   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
}
?>
