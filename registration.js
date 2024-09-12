function formValidation() {
    var isValid = true;

    // First name validation
    var fname = document.getElementById("fn").value;
    if (fname.length === 1 || fname.length === 0 || fname.search(/[0-9]/) === 1) {
        document.getElementById("fname-error").innerText = "Please enter a valid first name";
        document.getElementById("fname-error").style.color = "red";
        isValid = false;
    } else {
        document.getElementById("fname-error").innerText = "";
    }

    // Middle name validation
    var mname = document.getElementById("mn").value;
    if (mname.length === 1 || mname.length === 0 || mname.search(/[0-9]/) === 1) {
        document.getElementById("mname-error").innerText = "Please enter a valid middle name";
        document.getElementById("mname-error").style.color = "red";
        isValid = false;
    } else {
        document.getElementById("mname-error").innerText = "";
    }

    // Last name validation
    var lname = document.getElementById("ln").value;
    if (lname.length === 1 || lname.length === 0 || lname.search(/[0-9]/) === 1) {
        document.getElementById("lname-error").innerText = "Please enter a valid last name";
        document.getElementById("lname-error").style.color = "red";
        isValid = false;
    } else {
        document.getElementById("lname-error").innerText = "";
    }

    // Date of birth validation
    var dob = document.getElementById("dob").value;
    if (dob === "") {
        document.getElementById("dob-error").innerText = "Please enter your date of birth";
        document.getElementById("dob-error").style.color = "red";
        isValid = false;
    } else {
        var today = new Date();
        var birthDate = new Date(dob);
        var age = today.getFullYear() - birthDate.getFullYear();
        var monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        if (age < 18) {
            document.getElementById("dob-error").innerText = "You must be at least 18 years old to register";
            document.getElementById("dob-error").style.color = "red";
            isValid = false;
        } else {
            document.getElementById("dob-error").innerText = "";
        }
    }

    // Mobile number validation
    var mno = document.getElementById("mno").value;
    var mobileRegex = /^[0-9]+$/;
    if (mno.length !== 10 || !mobileRegex.test(mno.trim())) {
        document.getElementById("mno-error").innerText = "Please enter a valid mobile number";
        document.getElementById("mno-error").style.color = "red";
        isValid = false;
    } else {
        document.getElementById("mno-error").innerText = "";
    }

    // Email validation
    var email = document.getElementById("eid").value;
    if (email === "") {
        document.getElementById("eid-error").innerText = "Please enter your email address";
        document.getElementById("eid-error").style.color = "red";
        isValid = false;
    } else if (!email.endsWith("@gmail.com")) {
        document.getElementById("eid-error").innerText = "Please enter a valid email address";
        document.getElementById("eid-error").style.color = "red";
        isValid = false;
    } else {
        document.getElementById("eid-error").innerText = "";
    }    

    // Password and confirm password validation
    var pass = document.getElementById("pwd").value;
    var cpass = document.getElementById("cpwd").value;
    if (pass === "") {
        document.getElementById("pwd-error").innerText = "Please create a password";
        document.getElementById("pwd-error").style.color = "red";
        isValid = false;
    } else if (pass.length < 8) {
        document.getElementById("pwd-error").innerText = "Password must be at least 8 characters long";
        document.getElementById("pwd-error").style.color = "red";
        isValid = false;
    } else if (pass.search(/[0-9]/) === -1) {
        document.getElementById("pwd-error").innerText = "Password must contain at least one number";
        document.getElementById("pwd-error").style.color = "red";
        isValid = false;
    } else if (pass.search(/[A-Z]/) === -1) {
        document.getElementById("pwd-error").innerText = "Password must contain at least one uppercase character";
        document.getElementById("pwd-error").style.color = "red";
        isValid = false;
    } else if (pass.search(/[a-z]/) === -1) {
        document.getElementById("pwd-error").innerText = "Password must contain at least one lowercase character";
        document.getElementById("pwd-error").style.color = "red";
        isValid = false;
    } else {
        document.getElementById("pwd-error").innerText = "";
    }

    if (pass !== cpass) {
        document.getElementById("cpwd-error").innerText = "Confirm password doesn't match";
        document.getElementById("cpwd-error").style.color = "red";
        isValid = false;
    } else {
        document.getElementById("cpwd-error").innerText = "";
    }

    return isValid;
}
