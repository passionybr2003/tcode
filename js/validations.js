$(document).ready(function(){
    $('#signup-form').validate({
        rules: {
            email: {                
                required: true,
                email:true,
                remote: {
	                url:"/takecode/functions.php",
	                type:"post",
	                data: {
	                    email:function(){
	                        return $('#email').val();
	                    },
	                    method:function(){
	                    	return "email_validation";
	                    }
	                }
	            } 
            },     
            pwd: {                
                required: true                
            },            
            cpwd: {
                required: true,
                equalTo: '#pwd'
            },
            mobile: {
                required: true,
                digits:true,
                minlength:10,
                maxlength:10
            }
        },
        messages: {
           
            email:{
                required: "Please enter Email",
                email: "Please enter valid email",
                remote : "Email is already taken."
            },
            pwd:{
                required: "Please enter Password"
            },
            cpwd:{
                required: "Please enter Confirm Password",
                equalTo : "Password does not match"
            },
            mobile:{
                required: "Please enter Cell Number",
                digits:"Please enter digits only.",
                minlength:"Mobile no should be min 10 digits.",
                maxlength:"Mobile no number should be max 10 digits."
            }
        }
    });
   
    $('#login-form').validate({
        rules: {
            email: {
                required: true,
                email:true
            },
            pwd: {                
                required: true                
            }  
        },
        messages: {
            email:{
                required: "Please enter Email",
                email: "Please enter valid Email"
            },
            pwd:{
                required: "Please enter password"
            }
        }
    });

    
    $('.error').hide();
//    $('#signup-form #email').blur(function(){
//    	$.ajax({
//    		url:"/takecode/classes/functions.php",
//            type:"get",
//            data: { method:'email_validation',email:$('#email').val() 	},
//            success: function(r) {
//            			if(r == 1){
//            				$('.error').show();
//            			} else {
//            				$('.error').hide();
//            			}
//            			
//                    }
//    	});
//    });
    
    
    
    
    
    
}); // end document.ready







