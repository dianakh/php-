
<!DOCTYPE html>


<html>
<head>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<!-- jquery validation plugin //-->

<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js"></script>


<script type="text/javascript" >



$(document).ready(function()

{
	
$('#zip').keyup(function(){
  if($(this).val().length == 5){
  var zip = $(this).val();
  var city = '';
  var state = '';
  //make a request to the google geocode api
  $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+zip)
  .success(function(response){
    //find the city and state
    var address_components = response.results[0].address_components;
    $.each(address_components, function(index, component){
      var types = component.types;
      $.each(types, function(index, type){
        if(type == 'locality') {
          city = component.long_name;
        }
        if(type == 'administrative_area_level_1') {
          state = component.short_name;
        }
      });
    });
    //pre-fill the city and state
    var cities = response.results[0].postcode_localities;
    if(cities) {
      //turn city into a dropdown if necessary
      var $select = $(document.createElement('select'));
      console.log(cities);
      $.each(cities, function(index, locality){
        var $option = $(document.createElement('option'));
        $option.html(locality);
        $option.attr('value',locality);
        if(city == locality) {
          $option.attr('selected','selected');
        }
        $select.append($option);
      });
      $select.attr('id','city');
      $('#city_wrap').html($select);
    } else {
      $('#city').val(city);
    }
    $('#state').val(state);
  });
  }
});

$.validator.addMethod("phone_mach", function(value, element) {

return this.optional(element) || /^[0-9]{3}-[0-9]{4}-[0-9]{4}$/i.test(value);//It returns false if the field is NOT empty, and it 
//returns the string “dependency-mismatch” if the field IS empty.

}, "Please choise a phone number with this format 000-0000-0000.");


// my method for validate username

$.validator.addMethod("user_mach", function(value, element) {

return this.optional(element) || /^[a-z0-9\.\-_]{3,30}$/i.test(value);

}, "Please choise a username with only a-z 0-9.");



$.validator.addMethod("code_mach", function(value, element) {

return this.optional(element) || /^[0-9\.\-_]{3,30}$/i.test(value);

}, "only 0-9 allwoed.");

$.validator.addMethod("city_mach", function(value, element) {

return this.optional(element) || /^[a-zA-Z\.\-_]{3,30}$/i.test(value);

}, "only a-z allowed .");



$("#form").validate(

{

rules:{

username:{

required: true,

minlength: 3,

user_mach: true,

},

email:{

required: true,

email: true,

}, 

phone:{

required: true,

phone_mach: true,

},

password:{
required: true,
minlength: 8 ,
},
cpassword:{
	required: true,
equalTo: '#pass'

},


zip:{

required: true,
code_mach: true,
},

state:{

required: true,

},

city:{

required: true,

},
},



});
});

</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> User Registration Form</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body >

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<?php echo form_open_multipart('user/register','id="form"');?>

<div class="container">
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php echo $this->session->flashdata('verify_msg'); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>User Registration Form</h4>
            </div>
            <div class="panel-body">
               
                <div class="form-group">
                    <label for="name">UserName</label>
                    <input class="form-control required" name="username" placeholder="Your  Name" type="text" value="<?php echo set_value('username'); ?>" />
                    <span class="text-danger"><?php echo form_error('username'); ?></span>
                </div>

             
                <div class="form-group">
                    <label for="name">Phone Number</label>
                    <input class="form-control" name="phone" placeholder="000-0000-0000" type="text" value="<?php echo set_value('phone'); ?>" />
                    <span class="text-danger"><?php echo form_error('phone'); ?></span>
                </div>
               
                <div class="form-group">
                    <label for="email">Email ID</label>
                    <input class="form-control" name="email" placeholder="Email-ID" type="text" value="<?php echo set_value('email'); ?>" />
                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                </div>

                <div class="form-group">
                    <label for="subject">Password</label>
                    <input class="form-control" name="password" placeholder="Password" type="password" id="pass" />
                    <span class="text-danger"><?php echo form_error('password'); ?></span>
                </div>

                <div class="form-group">
                    <label for="subject">Confirm Password</label>
                    <input class="form-control" name="cpassword" placeholder="Confirm Password" type="password" />
                    <span class="text-danger"><?php echo form_error('cpassword'); ?></span>
                </div>
				 <div class="form-group">
                    <label for="subject">Zip Code</label>
                    <input class="form-control" name="zip" type="text" id="zip" />
                    <span class="text-danger"><?php echo form_error('zip'); ?></span>
                </div>
				 <div class="form-group">
                    <label for="subject">State</label>
                    <input class="form-control" name="state" type="text" id="state" />
                    <span class="text-danger"><?php echo form_error('state'); ?></span>
                </div>
				 <div class="form-group">
                    <label for="subject">City</label>
                    <input class="form-control" name="city"  type="text" id="city"/>
                    <span class="text-danger"><?php echo form_error('city'); ?></span>
                </div>
				
			    <div class="form-group">
				      <label for="subject">gender</label>
                     <select name="gender" id="sex-select">
	                 <option value="0">Select Sex:</option>
	                 <option value="female">Female</option>
	                 <option value="male">Male</option>
	                 </select> 
				 </div>
				   <div class="form-group">
				  
				<input type='file' name='picture' size='20' />
				  </div>
                <div class="form-group">
                    <button name="submit" type="submit" class="btn btn-default">Signup</button>
                    <button name="cancel" type="reset" class="btn btn-default">Cancel</button>
					<br>
					 <a href="<?php echo site_url('user/login') ?>">OR LOGIN IF YOU HAVE AN ACCOUNT </a>
                </div>
		
                <?php echo form_close(); ?>
			
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        </div>
    </div>
</div>
</div>

</body>
</html>
