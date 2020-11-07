
function ValidateForm(){ //the function that is called by the form, has to return true for the form to submit and create an account
  
    if(validateName()){
        if(validateEmail()){
            if(validateUsername()){
                if(validatePassword()){
                    if(validatePhone()){
                        if(validateAddress()){
                          if(validateDesc()){
                              return true;
                          };  
                        };
                    };
                };
            };
        };
    };
    return false;
};

function validateName(){
    var firstName = $("#firstname").val().trim(); 
    var lastName =  $("#lastname").val().trim();
    
    if(firstName !== ''){ 
        if(firstName.length > 50){
            alert("First Name cannot be greater than 50 characters");
            return false;
        }
    }
    else{
        alert("First Name cannot be blank");
        return false;
    }
    if(lastName !== ''){
        if(lastName.length > 50){
            alert("First Name cannot be greater than 50 characters");
            return false;
        }
    }
    else{
        alert("Last Name cannot be blank");
        return false;
    }
    return true;
}//end validate name

function validateEmail(){
    var email = $("#email").val().trim(); 
    var emailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    if(email !== ''){
        if(email.length > 100){
            alert("Email cannot be longer than 100 characters");
            return false;
        }
        else{
            if(!emailPattern.test(email)){
                alert("Please enter a valid email address");
                return false;
            }
        }
    }
    else{
        alert("Email is required");
        return false;
    }
    return true;

    
}//end validate email

function validateUsername(){
    var username = $("#username").val().trim();
    
    if(username !== ''){
        if(username.length > 50){
            alert("username cannot be greater than 50 characters");
            return false;
        }
    }
    else{
        alert("username cannot be blank");
        return false;
    }
    return true;
}//end validate username

function validatePassword(){
    var password = $("#password").val().trim(); 
    var confirmPassword = $("#confirm").val().trim();            
    
    if(password !== ''){
        if(password.length > 250){
            alert("Password cannot be longer than 250 characters");
            return false;
        }
    }
    else{
        alert("Password is required");
        return false;
    }
    
    if(confirmPassword !== ''){
        if(password !== confirmPassword){
            alert("Passwords must match");
            return false;
        }
    }
    else{
        alert("You must confirm your password");
        return false;
    }
    return true;
}//end validate password

function validateAddress(){
    var postalCode = $("#postalCode").val().trim();  
    var address = $("#address").val().trim(); 
    var province = document.getElementById("province");  //change this to use jquery maybe
    var postalPattern = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/;
    
    if(address !== ''){
        if(address.length <= 200){
            if(province.selectedIndex != 0){
                if(postalCode !== ''){
                    if(postalCode > 7){
                        alert("Postal code cannot be longer than 7 characters");
                        return false;
                                            }
                    else{
                        if(!postalPattern.test(postalCode)){
                            alert("Please enter a valide postal code");
                            return false;
                        }
                    }
                }    
                else{
                    alert("Postal Code is required");
                    return false;
                }
            }
            else{
                alert("You must choose a province");
                return false;
            }
        }
        else{
            alert("Address cannot be longer than 200 characters");
            return false
        }
    }
    else{
        alert("Address is required");
        return false;
    }
    return true;

}//end validateAddress();

function validatePhone(){
    var phonePattern = /1?[\s-]?\(?(\d{3})\)?[s-]?\d{3}[\s-]?\d{4}/;
    var phone = $("#phone").val().trim(); 
    if(phone !== ''){
        if(phone.length > 25){
             alert("Phone number cannot be longer than 25 characters");
             return false;
        }
        else{
            if(!phonePattern.test(phone)){
                alert("Please enter a valid phone number");
                return false;
            }
           
        }
    }
    else{
        alert("Phone number is required");
        return false;
    }
    return true;
}//end ValidatePhone();

function validateURL(){
    var url = $("#url").val().trim();
    
    if(url.length > 50){
            alert("URL cannot be greater than 50 characters");
            return false;
    }
    return true;
    
}//end validateURL();

function validateLocation(){
    var location = $("#location").val().trim();
    if(location.length > 50){
        alert("Location cannot be greater than 50 characters");
        return false;
    }
    return true;    
}//end validateLocation

function validateDesc(){
    var desc = $("#desc").val().trim();
    
    if(desc != ''){
        if(desc.length > 160){
            alert("Description cannot be longer than 160 characters");
            return false;
        }
    }
    else{
        alert("Description is required");
        return false;
    }
    return true;
}//end validate Desc

