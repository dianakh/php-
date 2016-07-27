<?php
class user_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //insert into user table
    function insertUser($data)
    {
        return $this->db->insert('user', $data);
    }
	
		
	  //send verification email to user's email id
    function sendEmail($to_email)
    {
			$confirmedcode= base64_encode($to_email); 
        $from_email = 'khdiana1994@gmail.com';
        $subject = 'Verify Your Email Address';
        $message = "Thanks for signing up!
   Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.


 
   Please click this link to activate your account:
  http://localhost/CodeIgniter-3.0.6/index.php/user/verify?code=$confirmedcode";

        
        //send mail
        $this->email->from($from_email, 'website');
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }
    
    //activate user account
    function verifyEmailID($key)
    {
		 
$this->db->select('email');
$this->db->where('email', $key);
$query = $this->db->get('user');
$rowcount = $query->num_rows();
if($rowcount){
	   $data = array('status' => 1);
        $this->db->where('email', $key);
        return $this->db->update('user', $data);
}


}
    
	//login 
      function get_user($usr, $pwd)
     {
          $sql = "select * from user where username = '" . $usr . "' and password = '" . md5($pwd) . "'";
         $query = $this->db->query($sql);
          return $query->num_rows();
		  
     }
	   function insertArticle($data)
    {
        return $this->db->insert('article', $data);
    }
	
	
	
}

?>