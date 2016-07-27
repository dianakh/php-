<?php
class user extends CI_Controller
{
    public function __construct()
    {
		
        parent::__construct();
       $this->load->helper(array('form','url'));
		$autoload['helper'] = array('url');
        $this->load->library(array('session', 'form_validation', 'email'));
        $this->load->database();
	$this->load->helper('security'); //xss clean ,hashing ...
	$this->load->helper('form'); //html_escape(),form_open....
	$this->load->library('javascript'); // to load JavaScript library
$this->load->library('javascript/jquery');
        $this->load->model('user_model');
		$this->load->helper('html');
	
    }
    
    function index()
    {
        
    }
	
	
    function register()
    {
		
        //set validation rules
        $this->form_validation->set_rules('username', 'First Name', 'trim|required|alpha|min_length[3]|max_length[30]|is_unique[user.username]|xss_clean');
        $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('phone', 'Home Phone', 'required|regex_match[/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/i]|xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'required'); 
		$this->form_validation->set_rules('zip','zipcode','trim|required|min_length[5]|numeric|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|max_length[30]|xss_clean');
	    $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[30]|xss_clean');	
        
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[cpassword]|md5');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required');
        
        //validate form input
        if ($this->form_validation->run() == FALSE)
        {
            // fails
            $this->load->view('user_registration_view');
        }
    	
    
    else{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config); 
        $this->upload->initialize($config);
		if ( ! $this->upload->do_upload('picture'))
		{
			  // error
			
                $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">your file cant be uploaded</div>');
			$this->load->view('user_registration_view');
		}
		else
		{
			$data =$this->upload->data();
		
			  $image = $data['file_name'];
			
            //insert the user registration details into database
			$email= $this->input->post('email');
			
			 $gender = $this->input->post('gender');
			
			
			$zipcode=$this->input->post('zip');
			$city=$this->input->post('city');
			$state=$this->input->post('state');
			
		    
			
			
            $data = array(
                'username' => $this->input->post('username'),
                'email' =>$email,
				'phone' => $this->input->post('phone'),
                'password' => $this->input->post('password'),
				'zip' =>$zipcode,
				'state'=>$state,
				'city'=>$city,
				'gender'=>$gender,
				'image_name'=>$image
			
            );
            
            // insert form data into database
            if ($this->user_model->insertUser($data))
            {
        
                    
                  // send email
                if ($this->user_model->sendEmail($this->input->post('email')))
                {
                    // successfully sent mail
                    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">You are Successfully Registered! Please confirm the mail sent to your Email-ID!!!</div>');
                    redirect('user/register');
                }
                else
                {
                    // error
                    $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!</div>');
                    redirect('user/register');
                }
               
			   redirect('user/register');
            }
            else
            {
                // error
                $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
                redirect('user/register');
            }
        }
		}
	}
	
        function verify()
    {
		
		
$hash= base64_decode($_GET['code']);
	$num=$this->user_model->verifyEmailID($hash);
        if ($num>0)
        {

            $this->session->set_flashdata('verify_msg','<div class="alert alert-success text-center">Your Email Address is successfully verified! Please login to access your account!</div>');
            redirect('user/register');
        }
        else
        {
            $this->session->set_flashdata('verify_msg','<div class="alert alert-danger text-center">Sorry! There is error verifying your Email Address!</div>');
            redirect('user/register');
        }
    }
	
    public function login() {
	
          //get the posted values
          $username = $this->input->post("txt_username");
          $password = $this->input->post("txt_password");

          //set validations
          $this->form_validation->set_rules("txt_username", "Username", "trim|required");
          $this->form_validation->set_rules("txt_password", "Password", "trim|required");

          if ($this->form_validation->run() == FALSE)
          {
               //validation fails
               $this->load->view('login_view');
          }
          else
          {
               //validation succeeds
               if ($this->input->post('btn_login') == "Login")
               {
                   //check if username and password is correct
                    $usr_result = $this->user_model->get_user($username, $password);
                    if ($usr_result > 0) //active user record is present
                    {
						
						$_SESSION['username']=$username;
						
		     $this->db->select('email,image_name,phone,username,city,state');
             $this->db->where('username', $username);
              $query = $this->db->get('user');
              $resultq1= $query->result_array();
               $data['resultq1'] = $resultq1;
                  $_SESSION['information']=  $data['resultq1'];
						    $sql = "select * from user where username = '" . $username . "'";
                             $query = $this->db->query($sql);
	                       foreach ($query->result() as $row)
                            {
	                         $_SESSION['id']= $row->id;
       
     
                            }
                         redirect('user/home');
                    }
                    else
                    {
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
						 
                         redirect('user/login');
                    }
               }
               else
               {
                    redirect('user/login');
               }
          }
}
 public function home() { 
if(!isset($_SESSION['id'])){
    # redirect to the login page
	
  redirect('user/login');
}  

	
  $this->load->view('home');
}
 public function profile() { 
 
    if(!isset($_SESSION['id'])){
    # redirect to the login page
	
  redirect('user/login');
}  
    $this->db->select('email,image_name,phone,username,city,state,id');
             $this->db->where('id', $_SESSION['id']);
              $query = $this->db->get('user');
              $resultq1= $query->result_array();
               $data['resultq1'] = $resultq1;


                 $this->load->view('profile',$data);
}
public function logout() {
	if(!isset($_SESSION['id'])){
    # redirect to the login page
	
  redirect('user/login');
}  

	
  $this->load->view('home');
	
// Removing session data

$this->session->sess_destroy();
 $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">successfully loged out </div>');
  redirect('user/login');
}
public function update() { 
if(!isset($_SESSION['id'])){
    # redirect to the login page
	
  redirect('user/login');
}
$this->db->select('email,image_name,phone,username,city,state,id');
             $this->db->where('id', $_SESSION['id']);
              $query = $this->db->get('user');
              $resultq1= $query->result_array();
               $data['resultq1'] = $resultq1;

	   $this->load->view('update',$data);
}
public function performUpdate() { 

    $nameError='';$passwordError='';$phoneError='';$dateError='';$passwordError1='';$imageError='';

 $this->form_validation->set_rules('username', 'First Name', 'trim|alpha|min_length[3]|max_length[30]|is_unique[user.username]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|md5');
				$this->form_validation->set_rules('phone', 'Home Phone', 'regex_match[/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/i]|xss_clean');
      
        
        //validate form input
        if ($this->form_validation->run() == FALSE)
        {
							    $sql = "select * from user where id = '" . $_SESSION['id'] . "'";
                             $query = $this->db->query($sql);
	                       foreach ($query->result() as $row)
                            {
	                     
   echo form_error('username');
   echo "||";
   echo $row->username;
   echo "||";
  echo form_error('phone');
   echo "||";
   echo $row->phone;
   echo "||";
   echo form_error('password');
       echo "||";
   echo form_error('cpassword');
         echo "||";
   echo $row->image_name;
         echo "||";
   echo $imageError;
			
		}
		     
		}

else{
	



      if( $this->input->post('username') !='')
     {
	 $new = array('username' => $this->input->post('username'));
        $this->db->where('id', $_SESSION['id']);
        $this->db->update('user', $new);
        $nameError="username updated successfully";
     }
	 if( $this->input->post('phone') !='')
      {
	    $new = array('phone' => $this->input->post('phone'));
        $this->db->where('id', $_SESSION['id']);
        $this->db->update('user', $new);
		 $phoneError="phone updated successfully";			   
     }
	 
	   
	  
   if( $this->input->post('password')!='' )
	  {
  if($this->input->post('cpassword')!='')
  {
				        $sql = "select * from user where id = '" . $_SESSION['id'] . "'";
                          $query = $this->db->query($sql);
	                     foreach ($query->result() as $row)
                            
	                      

	{
		if(md5($this->input->post('cpassword'))==$row->password)

	     
			   {
			   	   
				   
    $password= md5($this->input->post('password')) ;

$new = array('password' => $password);
        $this->db->where('id', $_SESSION['id']);
        $this->db->update('user', $new);
		$passwordError="password updated successfully";
       
	  }
	  else{ $passwordError1="password not match ";}
  }
  }
	  else{ $passwordError1="please enter the old password";}
      }
if (!empty($_FILES['file']['name'])) {

	    $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config); 
        $this->upload->initialize($config);
		if ( ! $this->upload->do_upload('file'))
		{
			  // error
			
               $imageError="you photo cant be uploaded";
		}
		else
		{
			$data =$this->upload->data();
		
			  $image = $data['file_name'];
			  $new = array('image_name' => $image);
        $this->db->where('id', $_SESSION['id']);
        $this->db->update('user', $new);
		$imageError="image updated successfully";
		}
}

						    $sql = "select * from user where id = '" . $_SESSION['id'] . "'";
                             $query = $this->db->query($sql);
	                       foreach ($query->result() as $row)
                            {
	                     
   echo $nameError;
   echo "||";
   echo $row->username;
   echo "||";
   echo $phoneError;
   echo "||";
   echo $row->phone;
   echo "||";
   echo $passwordError;
   echo "||";
   echo $passwordError1;
   echo "||";
   echo $row->image_name;
   echo "||";
   echo $imageError;

     
                          }
              }
	      }
		  
		public function addArticle() { 

		
		$this->load->view('addArticle');
 
       }
	   
	   public function addArticle_DB() { 
	   	
        //set validation rules
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[6]|max_length[15]|xss_clean');
        $this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[10]');
		 $this->form_validation->set_rules('author', 'Author', 'trim|required|min_length[3]');
		
        //validate form input
        if ($this->form_validation->run() == FALSE)
        {
			
            // fails
            $this->load->view('addArticle');
        }
    	
    
    else{
		  
		  $data = array(
			'Title'=> $this->input->post('title'),
			'Body'=> $this->input->post('content'),
			'Author'=> $this->input->post('author'),
			'id'=>$_SESSION['id']
				
			
            );
            
            // insert form data into database
            if ($this->user_model->insertArticle($data))
            {

		$this->db->select('ID_article');
$this->db->from('article');
$this->db->where('id', $_SESSION['id']);
$query = $this->db->get();
foreach ($query->result() as $row)
{
        $article_id= $row->ID_article;
}
			
   extract($_POST);
    $error=array();
    $extension=array("jpeg","jpg","png","gif");
	$total = count($_FILES['upload']['name']);

  // Count # of uploaded files in array
// Loop through each file
for($i=0; $i<$total; $i++) {
  //Get the temp file path
  $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

  //Make sure we have a filepath
  
    //Setup our new file path
    $newFilePath = './uploads/'. $_FILES['upload']['name'][$i];

    //Upload the file into the temp dir
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
	
	 $data = array(
                'images' => $_FILES['upload']['name'][$i],
	'ID_article' =>$article_id
	);
		 $this->db->insert('image', $data);
			  
    }
	

    }
  redirect('user/viewArticle');
}
	   
	   }
	     }
	   
	   //view articles 
	   public function viewArticle()
	   {
		   
		   $this->db->select('*');
           $query = $this->db->get('article');
		   $resultq1= $query->result_array();
           $rowcount = $query->num_rows();
           $data['articleNum']=  $rowcount;
           $data['resultq1'] = $resultq1;	
       
			  $this->load->view('viewArticle',$data);
		   }
		   
		   	   public function viewMyArticle() {
		   
$this->db->select('*');
$this->db->where('id',$_SESSION['id']);
$query = $this->db->get('article');
$rowcount = $query->num_rows();
	$i=0;
foreach ($query->result() as $row)
{
	    echo "<div style='display:inline-block;margin-right:5px;'>";
		echo "<br>";
	    echo "<br>";
        echo"<b>";

	   echo "Article".++$i;
    echo"</b>";
	echo "<br>";
	echo "<br>";
    echo"<article>";
	echo"Author:" . $row->Author;
	echo"</article>";
		echo "<br>";
		echo $row->Title;
		echo "<br>";
		echo "<br>";
		echo"<strong>";
		echo"<i>";
		echo $row->Body;
		echo"</i>";
		echo"</strong>";
		echo "<br>";
		
		$article=$row->ID_article;
$this->db->select('images');
$this->db->from('image');
$this->db->where('ID_article',$article);
$query = $this->db->get();
$rowcount = $query->num_rows();

foreach ($query->result() as $row)
{

	$image_properties = array(
        'src'   => 'uploads/'.$row->images.'',
        'width' => '200',
        'height'=> '200',
        'title' => 'That was quite a night',
        'rel'   => 'lightbox'
);
    echo "<div style='display:inline-block;margin-right:5px;'>";
	echo img($image_properties);      
}	
 echo'  </div>';
         
}
		

		   
		   }
		   
		  public function deleteMyArticle() { 
		   $this->db->select('*');
           $this->db->where('id',$_SESSION['id']);
           $query = $this->db->get('article');
           $rowcount = $query->num_rows();
           $resultq1= $query->result_array();
		   $data['num']=  $rowcount;
           $data['resultq1'] = $resultq1;	

	
		  $this->load->view('deleteMyArticle',$data);

		   
		  
}
}