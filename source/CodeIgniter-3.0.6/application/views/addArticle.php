
<!DOCTYPE html>


<html>
<head>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Add Article </title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
				       <li ><a href="<?php echo site_url('user/home') ;?>">Home</a></li>
                     

                     
                </ul> 
                
            </div>

 </nav>
 </div>
   <div class="row">
  	<div class="col-md-7 col-md-offset-2">
<img src="<?php echo base_url('assest/img/logo.png'); ?>" class="img-responsive">
</div> 


  </div>
<div class="container">

<div  class="row">
<?php echo form_open_multipart('user/addArticle_DB','id="form"');?>

<div class="form-group">
 <?php echo form_input('title', set_value('title', 'Title')); ?><br /></div>
        <?php echo form_textarea('content', set_value('content', 'Content')); ?><br />
        <?php echo form_input('author', set_value('author', 'Author')); ?>
		   <div class="form-group">
				  
				<input name="upload[]" type="file" multiple="multiple" size='20' />
				  </div>
        <?php echo form_submit('submit', 'Add Article'); ?>
        <?php echo validation_errors('<p class="error">' );?>
		</div>
		</div>
                <?php echo form_close(); ?>
			
                <?php echo $this->session->flashdata('msg'); ?>
</body>
</html>