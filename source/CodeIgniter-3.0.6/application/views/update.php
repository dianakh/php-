<?php
 //   $nameError='';$passwordError='';$phoneError='';$dateError='';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<!-- jquery validation plugin //-->

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js"></script>
 
<script type="text/javascript" >

$(document).ready(function() {
		
$("#form").on('submit',(function(e) {
e.preventDefault();

$.ajax({
url: "<?php echo base_url(); ?>" +"index.php/user/performUpdate", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{

	


	  var splitResponse =data.split( "||" );
var firstDropdownContent = splitResponse[0];
var secondDropdownContent = splitResponse[1];
var thDropdownContent = splitResponse[2];
var fourthDropdownContent = splitResponse[3];
var passDropdownContent = splitResponse[4];
var confDropdownContent = splitResponse[5];
var imageDropdownContent = splitResponse[6];
var errorDropdownContent = splitResponse[7];


         var ajaxDisplay = document.getElementById('c1');
		   var ajaxDisplay2 = document.getElementById('err1');
         ajaxDisplay.innerHTML = secondDropdownContent;
		    ajaxDisplay2.innerHTML = firstDropdownContent;
			 var ajaxDisplay3 = document.getElementById('c2');
		   var ajaxDisplay4 = document.getElementById('err2');
         ajaxDisplay4.innerHTML = thDropdownContent;
		    ajaxDisplay3.innerHTML = fourthDropdownContent;
			 var ajaxDisplay4 = document.getElementById('pass');
		   var ajaxDisplay5 = document.getElementById('conf');
         ajaxDisplay4.innerHTML = passDropdownContent;
		    ajaxDisplay5.innerHTML = confDropdownContent;
		 var ajaxDisplay6 = document.getElementById('c3');
		   var ajaxDisplay7 = document.getElementById('message');
         ajaxDisplay6.innerHTML = imageDropdownContent;
		    ajaxDisplay7.innerHTML = errorDropdownContent;
			
			
		
			
}
});

}));
// Function to preview image after validation
$(function() {
$("#file").change(function() {
$("#message").empty(); // To remove the previous error message
var file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{
$('#c3').attr('src','noimage.png');
$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});
function imageIsLoaded(e) {

$('#c3').attr('src', e.target.result);

};
$.validator.addMethod("phone_mach", function(value, element) {

return this.optional(element) || /^[0-9]{3}-[0-9]{4}-[0-9]{4}$/i.test(value);//It returns false if the field is NOT empty, and it 
//returns the string “dependency-mismatch” if the field IS empty.

}, "Please choise a phone number with this format 000-0000-0000.");


// my method for validate username

$.validator.addMethod("user_mach", function(value, element) {

return this.optional(element) || /^[a-z0-9\.\-_]{3,30}$/i.test(value);

}, "Please choise a username with only a-z 0-9.");


$("#form").validate(

{

rules:{


username:{

minlength: 3,

user_mach: true,



},

password:{

minlength: 8

},
cpassword:{

minlength: 8

},
phone:{




phone_mach: true,



},

},


});


});
</script>
    <title>sweet home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 

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
	<h1 align="center" style="border:1px solid  ">
Edit your profile
</h1>
        <div class="form-group col-4-offset-3">
		  <?php foreach($resultq1 as $row):?>
  <img id="c3" class="img-circle" src="<?php echo base_url('uploads/'.$row['image_name'].''); ?>"" alt="" height="100" width="100" /> 
 
     
  <h4>  name:</h4><h4 id="c1"><?php echo $row['username'] ;?> </h4>
		</div>
		</div>
		</div>
		</div>
      <div class="row">
    	
			
	<div class="container">
	   <h4>phone number:</h4> <h3 id="c2"><?php echo $row['phone']; ?> </h3>
	   
<form id=form method="post" action="" autocomplete="off" enctype="multipart/form-data">

<div>
<h4 id="d1">change user name</h4></div><span id="err1" ></span>
<div id="showuser" > <input type="text"  id="duser" name="username"   > <span class="text-danger"><?php echo form_error('username'); ?></span>
</div>
<div>
<h4 id="d1">change Password</h4> </div><span id="pass" ></span>
<div  > <input type="text"  name="password"><span class="text-danger"><?php echo form_error('password'); ?></span>
</div>
<div>
<h4 id="d1">old Password</h4> </div><span id="conf" > </span>
<div  > <input type="text"  name="cpassword" ><span class="text-danger"><?php echo form_error('cpassword'); ?></span>
</div>
<div>
<h3 id="d3">change phone</h3> <span id="err2"> </span>
<td><div id="showphone"> <input type="text" id="phone" name="phone"  placeholder=000-0000-0000 ><span class="text-danger"><?php echo form_error('phone'); ?></span>
</div>
<h3 id="d4">change profile picture</h3>
<div id="showimage"> 
<input type="file" name="file" id="file" />
<br>
<br>
<div id="message"> </div>
<input type="submit" id="pic" name="submit3"  value="update" class=" btn-primary" font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; font-size:70px"></div></div>
 					  
                   
 <?php endforeach;?>
</form>
</body>
</html>