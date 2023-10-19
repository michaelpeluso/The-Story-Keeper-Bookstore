
//variables
let fNameInput;
let lNameInput;
let passInput;
let idNumInput;
let phoneInput;
let emailInput;
let emailCheckbox;
let transactionDropDown;

let allInputs = [];
let invalidInput = null;
let isActive;

let textColor = "rgb(70, 66, 65)";
let inputColor = "rgb(176, 164, 150)";
let invalidColor = "rgb(150, 81, 76)";



//screen resolution asjustment
if (window.innerWidth / window.innerHeight < 1.0) {
    document.getElementById("container").style.zoom = "200%";
    document.getElementsByTagName("body")[0].style.backgroundImage = 'url("libraryShelves3.jpg")';
    document.getElementsByTagName("body")[0].style.backgroundRepeat = 'repeat';
}



//on hover functions
window.onmouseover=function(e) {
    for (var i = 0; i < allInputs.length; i++) {
        if (e.target == allInputs[i]) {
            e.target.style.backgroundColor = textColor;
        } 
    }
}

document.addEventListener('click', function(e) {
    allInputs.forEach(function(input) {
        if (e.target == input) {
            input.style.backgroundColor = textColor;
            isActive = input;
        }
        else {
            input.style.backgroundColor = inputColor;
            if (invalidInput != null && invalidInput == input) {
                invalidInput.style.backgroundColor = invalidColor;
            }
        }
    });
});

window.onmouseout=function(e) {
    for (var i = 0; i < allInputs.length; i++) {
        if (e.target == allInputs[i] && allInputs[i] != isActive) {
            e.target.style.backgroundColor = inputColor;
            if (invalidInput == allInputs[i]) {
                e.target.style.backgroundColor = invalidColor;
            }
        } 
    }
}



//page-defined functions
function indexPage() {
    reset();
    fNameInput = document.getElementById("fname");
    lNameInput = document.getElementById("lname");
    passInput = document.getElementById("pass");
    idNumInput = document.getElementById("idNum");
    phoneInput = document.getElementById("phone");
    emailInput = document.getElementById("email");
    emailCheckbox = document.getElementById("emailConfirmation");
    transactionDropDown = document.getElementById("transactions");
    allInputs = Array.from(document.getElementById("form").elements);
}

function formsPage() {
}

function sellerAccountsPage() {
}

function purFormPage() {
    reset();
}

function newCusPage() {
    reset();
}



var fileName = window.location.pathname.split("/").pop();
if (fileName == 'index.php') {
    
    fNameInput = document.getElementById("fname");
    lNameInput = document.getElementById("lname");
    passInput = document.getElementById("pass");
    idNumInput = document.getElementById("idNum");
    phoneInput = document.getElementById("phone");
    emailInput = document.getElementById("email");
    emailCheckbox = document.getElementById("emailConfirmation");
    transactionDropDown = document.getElementById("transactions");
    allInputs = Array.from(document.getElementById("form").elements);
}


//algarithmic functions
function validate()
{
    for (let i = 0; i < allInputs.length; i++) 
    {
        if ( checkValidInput(allInputs[i]) ) {
            allInputs[i].style.backgroundColor = inputColor;
        }
        else { //invalid input
            allInputs[i].style.backgroundColor = invalidColor;
            invalidInput = allInputs[i];
            return;
        }
    } //valid input
    
    window.open("index.php?" + 
        "valid=true" + 
        "&fName="+ fNameInput.value +
        "&lName=" + lNameInput.value +
        "&pass=" + passInput.value +
        "&idNum=" + idNumInput.value +
        "&phone=" + phoneInput.value +
        "&email=" + emailInput.value +
        "&transaction=" + transactionDropDown.selectedIndex
        ,"_self");
        invalidInput = null;
}

function checkValidInput(input) 
{
    if (input.id == "fname" || input.id == "lname" || input.id == "cfname" || input.id == "clname") { //first and last name
        if (/^[A-Z][A-za-z]{0,20}$/.test(input.value)) {
            return true;
        }
        if (input.id == "fname") { 
            alert("\n\
            INVALID ENTRY\n\
            Book Seller's First Name:\n\
                - contains only letters\n\
                - begins with a capital letter\n\
                - maximum of 20 characters\n\
            ");
        }
        else { 
            alert("\n\
            INVALID ENTRY\n\
            Book Seller's Last Name:\n\
                - contains only letters\n\
                - begins with a capital letter\n\
                - maximum of 20 characters\n\
            ");
        }
    }
    else if (input.id == "pass") { //password
        if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{1,10}$/.test(input.value)) {
            return true;
        }
        alert("\n\
        INVALID ENTRY\n\
        Book Seller's Password:\n\
            - contains at least 1 lower case letter\n\
            - contains at least 1 upper case letter\n\
            - contains at least 1 number\n\
            - contains at least 1 special character\n\
            - maximum of 10 characters\n\
        ");
    }
    else if (input.id == "idNum") { //id number
        if (/^[0-9]{8}$/.test(input.value)) {
            return true;
        }
        alert("\n\
        INVALID ENTRY\n\
        Book Seller's ID:\n\
            - contains only numbers\n\
            - excatly 8 characters\n\
        ");
    }
    else if (input.id == "phone") { //phone number
        if (/^[0-9]{3}( |-)?[0-9]{3}( |-)?[0-9]{4}$/.test(input.value)) {
            return true;
        }
        alert("\n\
        INVALID ENTRY\n\
        Book Seller's Phone Number:\n\
            - excatly 10 numbers\n\
            - first 3 digits can be separated by a '-' or ' '\n\
            - last 4 digits can be separated by a '-' or ' '\n\
        ");
    }
    else if (input.id == "email") { //email
        if (/^\w+@\w+\.\w{2,5}$/.test(input.value) && emailCheckbox.checked || input.value == "" && !emailCheckbox.checked) {
            return true;
        }
        alert("\n\
        INVALID ENTRY\n\
        Book Seller's Email:\n\
            - must be completed if checkbox is checked\n\
            - must be empty if checkbox is unchecked\n\
            - contains any string of alphanumeric characters\n\
            - conatians 1 '@' character\n\
            - contains 1 '.' following a '@' character\n\
            - conatains any string of alphanumeric characters between '@' and '.' characters\n\
            - ends with a string of between 2 and 5 alphanumeric charaters \n\
        ");
    }
    else if (input.id == "emailConfirmation") {
        return true;
    }
    else if (input.id == "transactions") {
        return true;
    }
    return false;
}

//clear user entries
function reset()
{
    var inputs = document.getElementsByTagName('input');
    for (let i = 0; i < inputs.length; i++) 
    {
        inputs[i].style.backgroundColor = inputColor;
        inputs[i].value = "";
        if (invalidInput == inputs[i]) {
            inputs[i].style.backgroundColor = invalidColor;
        }
    }
    inputs = document.getElementsByTagName('select');
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].value = 0;
    }
    if (document.getElementById("emailConfirmation")) {
        document.getElementById("emailConfirmation").checked = false;
    }
    if (invalidInput != null) {
        invalidInput.style.backgroundColor = invalidColor;
    }
    resetDate();
}

//open pages
function openForms() { window.open("forms.php","_self"); }
function openIndex() { window.open("index.html","_self"); }

//set date to today on 'Purchase Form'
function resetDate() {
    if (document.getElementById("date")) {
        var today = new Date();
        var month = "";
        var day = "";
        month = today.getMonth() < 10 ? '0'+today.getMonth() : today.getMonth();
        day = today.getDate() < 10 ? '0'+today.getDate() : today.getDate();
        var date = today.getFullYear()+'-'+(month+1)+'-'+day;
        document.getElementById("date").value = date;
    }
}

function purchaseSubmit() 
{
    //get input fields
    var inputFields = Array.from(document.getElementsByTagName('input'));
    inputFields.splice(5, 0, document.getElementById('orderType'));
    inputFields.splice(5, 0, document.getElementById('payType'));
    var validPurchase = false;
    
    //fix input color
    inputFields.forEach(element => element.style.backgroundColor = inputColor);
    
    //every text input
    for(var i = 0; i < inputFields.length; i++) {
           
        //customer id
        if (i == 2 && inputFields[i].value.length != 8) {
            alert("\n\INVALID ENTRY\n\Customer ID must contain 8 digits.");
            invalidInput = inputFields[i];
            break;
        }
        
        //in store or online
        if (i == 3 || i == 4) {
            if (inputFields[3].value != "" || inputFields[4].value != "") {
                continue;
            }
            else {
                alert("\n\INVALID ENTRY\n\Must answer 1/2 of the required feilds:\n\- Customer's In-store Purchase\n\- Customer's Online Purchase");
                invalidInput = inputFields[i];
                break;
            }
        }
        
        
        //credit card number
        if (i == 8 && inputFields[5].value == "CREDIT" && inputFields[8].value.length != 19) {
            alert("\n\INVALID ENTRY\n\Must answer 'Credit Card Number' for credit purchases.\n\(include spaces)");
            invalidInput = inputFields[i];
            break;
        }
        else if (i == 8 && inputFields[5].value == "CASH" && inputFields[8].value != "") {
            alert("\n\INVALID ENTRY\n\'Credit Card Number' must be empty for cash purchases.");
            invalidInput = inputFields[i];
            break;
        }
        else if (i == 8 && inputFields[5].value == "CASH" && inputFields[8].value == "") {
            continue;
        }
    
        //if field empty
        if (inputFields[i].value == "" || inputFields[i].value == 0) {
            alert("\n\INVALID ENTRY\n\Must answer requried fields.");
            invalidInput = inputFields[i];
            break;
        }
        
        //if cash and online
        if (i == 5 && inputFields[5].value == 2 && inputFields[6].value == 2) {
            alert("\n\INVALID ENTRY\n\Must pay with creit for online purchases.");
            invalidInput = inputFields[i];
            break;
        }
        
        if (i == inputFields.length - 1) {
            validPurchase = true;
        }
    }
    
    //valid entries
    if (validPurchase) {
        invalidInput = null;
        inputFields.forEach(element => element.style.backgroundColor = inputColor);
        window.open("purchaseForm.php?" +
            "validPurchase=true" + 
            "&cfname="+ document.getElementById('cfname').value +
            "&clname=" + document.getElementById('clname').value +
            "&cidNum=" + document.getElementById('cidNum').value +
            "&storePur=" + document.getElementById('storePur').value +
            "&onlPur=" + document.getElementById('onlPur').value +
            "&date=" + document.getElementById('date').value +
            "&payType=" + document.getElementById('payType').value + " " + document.getElementById('cardNum').value +
            "&orderType=" + document.getElementById('orderType').value +
            "&address=" + document.getElementById('address').value
        ,"_self");
    }
    
    if (invalidInput) {
        invalidInput.style.backgroundColor = invalidColor;
    }
}
    

function newCusPage() {
    
}


