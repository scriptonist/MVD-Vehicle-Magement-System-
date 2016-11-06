<?php
class MVD
{
    private $db;

    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
    public function generateId(){
      $id = time();

    }
    public function register($name,$email,$phone,$pass)
    {
       try
       {
           $new_password = sha1(md5($pass));

           $stmt = $this->db->prepare("INSERT INTO mvd(name,email,phone,password)
                                                       VALUES(:name,:email, :phone, :pass)");

           $stmt->bindparam(":name", $name);
           $stmt->bindparam(":email", $email);
           $stmt->bindparam(":pass", $new_password);
           $stmt->bindParam(":phone",$phone);
           $stmt->execute();

           return $stmt;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
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

  public function login($email,$pass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM mvd WHERE email=:email LIMIT 1");
          $stmt->execute(array(':email'=>$email));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
            $new_password = sha1(md5($pass));
             if( $new_password == $userRow['password'])
             {
                session_start();
                $_SESSION['mvdId'] = $userRow['email'];
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

   public function is_loggedin()
   {
      if(isset($_SESSION['mvdId']))
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
        unset($_SESSION['mvdId']);
        return true;
   }
}
?>
