<?php


	 
		   $data['resultq1']=$_SESSION['information'];
        //set validation rules
        $this->form_validation->set_rules('username', 'First Name', 'trim|alpha|min_length[3]|max_length[30]|is_unique[user.username]|xss_clean');
		$this->form_validation->set_rules('phone', 'Home Phone', 'regex_match[/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/i]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|matches[cpassword]|md5');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim');
        
        //validate form input
        if ($this->form_validation->run() == FALSE)
        {
            // fails
           $this->load->view('update',$data);
        }
    	
    
    else{
		
        echo "<script  language=\"javascript\">
	

	alert('Hello! I am an alert box!')</script>";
	

}	

?>