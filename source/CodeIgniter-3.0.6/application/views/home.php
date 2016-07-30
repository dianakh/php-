<!doctype html>
<html>
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
<body >
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
                                <li class=" dropdown"><a href="#" class="dropdown-" data-toggle="dropdown" role="button" aria-expanded="false" >Your account <span class="caret"></span> </a>
                       <ul class="dropdown-menu" role="menu" >
					   
            <li> <a href="<?php echo site_url('user/profile') ;?>">Profile </a></li>
            <li><a href="<?php echo site_url('user/logout') ;?>" >sign out</a></li>
      
		      <li><a href="<?php echo site_url('user/update') ;?>">update profile</a></li>
          </ul>        
                    </li>

                     
                </ul> 
                
            </div>

 </nav>
 </div>
	<div class="container">
  <div class="row">
  	<div class="col-md-7 col-md-offset-2">
<img src="<?php echo base_url('assest/img/logo.png'); ?>" class="img-responsive">
</div> 


  </div>

    <div class="row">
	<nav class="navbar navbar-inverse" style="background-color:#5C1F1F; color:#EFE9E9;">
  <div class="container-fluid">
    <div class="navbar-header">
    </div>
     <ul class="nav navbar-nav">
                    <li ><a href="<?php echo site_url('user/home') ;?>">Home</a></li>
                   <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" >  Engineers  <span class="caret"></span></a>  
                       <ul class="dropdown-menu color:#EFE9E9; " >
            <li><a href="#" id="one" >Architecture Engineers</a></li>
            <li><a href="# "id="two" >Interior Engineers</a></li>
          </ul>  
           </li>		  
		     <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" >  Article  <span class="caret"></span></a>  
                       <ul class="dropdown-menu color:#EFE9E9; " >
                   <li ><a href="<?php echo site_url('user/addArticle') ;?>">Add Article</a></li>		         
                    <li ><a href="<?php echo site_url('user/viewArticle') ;?>">View Article</a></li>
					 <li ><a href="<?php echo site_url('user/viewMyArticle') ;?>">View My Article</a></li>
                 <li ><a href="<?php echo site_url('user/deleteMyArticle') ;?>">Delete My Article</a></li>
				 <li ><a href="<?php echo site_url('user/updateMyArticle') ;?>">Update My Article</a></li>
                   
                         </ul>  
                         </li>	 
                    
                </ul> 
  </div>
</nav>
    	
    </div> 
	   
   <div class=" col-md-12 " >
   
  
   <img src="<?php echo base_url('assest/img/h_log.png'); ?>" style="width:600px; height:300px;"/> <p ><a style="background-color:#6C3535; border:solid 1px #5C1F1F; " class="btn btn-primary btn-lg" href="#" role="button">Read more</a></p>
   
   
   <pre></pre>
   <img src="<?php echo base_url('assest/img/story1.jpg'); ?>" style="width:600px; height:300px;"/> <p ><a style="background-color:#6C3535; border:solid 1px #5C1F1F; " class="btn btn-primary btn-lg" href="#" role="button">Read more</a></p>
   
     <pre></pre>
   <img src="<?php echo base_url('assest/img/story3.jpg'); ?>" style="width:600px; height:300px;"/> <p ><a style="background-color:#6C3535; border:solid 1px #5C1F1F; " class="btn btn-primary btn-lg" href="#" role="button">Read more</a></p>
   
   
   
  <div class="row">
    
  <h1  style="color:#F5F5F5;">Welcome to our Sweet home</h1>

  <div class="row" > 
         <?php echo $this->session->flashdata('msg'); ?>
  </div>
  </div>
</div>

    
</div>

   
   
</body>
</html>