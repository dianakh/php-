
<!DOCTYPE html>
<html lang="en">
    <head>
	<style>

	</style>
	  <meta charset="utf-8">
    <title>sweet home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body ">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<div class="row"> 
<nav class="navbar navbar-default  navbar-inverse" style="background-color:#7C4546;">
   <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
				       <li ><a href="<?php echo site_url('user/home') ;?>">Home</a></li>
                                <li class=" dropdown"><a href="#" class="dropdown-" data-toggle="dropdown" role="button" aria-expanded="false" >Your account <span class="caret"></span> </a>
                       <ul class="dropdown-menu" role="menu" >
            <li><a href="<?php echo site_url('user/profile') ;?>">view profile</a></li>
            <li><a href="<?php echo site_url('user/logout') ;?>"  >sign out</a></li>
      
		      <li><a href="<?php echo site_url('user/update') ;?>" >update profile</a></li>
          </ul>        
                    </li>

                     
                </ul> 
                
            </div>

 </nav>
 </div>
    <div class="container">
    <div class="row">
		 
  <?php foreach($resultq1 as $row):?>
  
      <h4>Author: <?php echo $row['Author'];?> </h4>
	  <h4> <?php echo $row['Title'];?> </h4>	
	<?php    
	
		$article=$row['ID_article'];
        $this->db->select('images');
        $this->db->from('image');
        $this->db->where('ID_article',$article);
        $queryImage = $this->db->get();
		foreach($queryImage->result() as $row2):?>
        
	  <img class="img-circle" src="<?php echo base_url('uploads/'.$row2->images.''); ?>"" alt="" height="100" width="100" /> 
		 <?php 
		  endforeach;
		 
		 ?>
		 <div>
	 <h4><?php echo $row['Body']; ?> </h4>
	  </div>
		<br><br>
		<pre></pre>
		
	  	  
					  
                   
 <?php endforeach;?>
  </div>
    </body>
</html>
