
// *** VARIABLES *** //

let currentPage = "";
let allInputs = [];
let newLink = "";
let invalidInput = null;
let validPurchase = false;
let isActive;

let textColor = "rgb(70, 66, 65)";
let inputColor = "rgb(176, 164, 150)";
let invalidColor = "rgb(150, 81, 76)";



// *** PAGE-DEFINED FUNCTIONS *** //

function indexPage() 
{
    currentPage = "index.php";
    reset();
    
    allInputs = Array.from(document.getElementById("form").elements);
    newLink = "index.php?valid=true";
}

function formsPage() 
{
    currentPage = "forms.php";
}

function sellerAccountsPage() 
{
    currentPage = "sellerAccounts.php";
}

function purFormPage() 
{
    currentPage = "purchaseForm.php";
    reset();
    
    allInputs = Array.from(document.getElementById("form").elements);
    validPurchase = false;
    newLink = "purchaseForm.php?validPurchase=true";
}

function newCusPage() 
{
    currentPage = "newCustomer.php";
    reset();
        
    allInputs = Array.from(document.getElementById("form").elements);
    newLink = "newCustomer.php?validCusAcc=true";
}

function returnPage() 
{
    currentPage = "return.php";
    reset();
    
    allInputs = Array.from(document.getElementById("form").elements);
    newLink = "return.php?validReturn=true";
}

function updatePage() 
{
    currentPage = "update.php";
    reset();
    
    allInputs = Array.from(document.getElementById("form").elements);
    newLink = "update.php?validUpdate=true";
}

function cancelPage() 
{
    currentPage = "cancel.php";
    reset();
    
    allInputs = Array.from(document.getElementById("form").elements);
    newLink = "cancel.php?validCancel=true";
}



// *** ALGARITHMIC FUNCTIONS *** //

//validate user inputs
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
    
    //generate link
    allInputs.forEach((input) => {
        if (input.id == "emailConfirmation") {
            newLink += "&" + input.id + "=" + input.checked;
        }
        else if (input.nodeName == "select") {
            newLink += "&" + input.id + "=" + input.options[input.selectedIndex].text;
        }
        else {
            newLink += "&" + input.id + "=" + input.value;
        }
    });;
    window.open(newLink,"_self");
    console.log(newLink)
    invalidInput = null;
}


//check input is legal
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
        else if (input.id == "lname") { 
            alert("\n\
            INVALID ENTRY\n\
            Book Seller's Last Name:\n\
                - contains only letters\n\
                - begins with a capital letter\n\
                - maximum of 20 characters\n\
            ");
        }
        if (input.id == "cfname") { 
            alert("\n\
            INVALID ENTRY\n\
            Customer's First Name:\n\
                - contains only letters\n\
                - begins with a capital letter\n\
                - maximum of 20 characters\n\
            ");
        }
        else if (input.id == "clname") { 
            alert("\n\
            INVALID ENTRY\n\
            Customer's Last Name:\n\
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
    else if (input.id == "idNum" || input.id == "cidNum") { //id number
        if (/^[0-9]{8}$/.test(input.value)) {
            return true;
        }
        else if (input.id == "idNum") {
            alert("\n\
            INVALID ENTRY\n\
            Book Seller's ID:\n\
                - contains only numbers\n\
                - excatly 8 characters\n\
            ");
        }
        else if (input.id == "cidNum") {
            alert("\n\
            INVALID ENTRY\n\
            Customer's ID:\n\
                - contains only numbers\n\
                - excatly 8 characters\n\
            ");
        }
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
        if (/^\w+@\w+\.\w{2,5}$/.test(input.value) && document.getElementById("emailConfirmation").checked ||
        input.value == "" && !document.getElementById("emailConfirmation").checked) {
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
        if (input.value != "") {
            return true;
        }
        alert("\n\
        INVALID ENTRY\n\
        Select a transaction:\n\
            - must select an option\n\
        ");
    }
    else if (input.id == "storePur" || input.id == "storePurUpdate") { //store purchase
        if (/^.+ \$\d+\.\d{2}$/.test(input.value)) {
            return true;
        }
        else if (input.id == "storePur") {
            if (input.value == "" && /^.+ \$\d+\.\d{2}$/.test(document.getElementById("onlPur").value)) {
                return true;
            }
        }
        else if (input.id == "storePurUpdate") {
            if (input.value == "" && /^.+ \$\d+\.\d{2}$/.test(document.getElementById("onlPurUpdate").value)) {
                return true;
            }
        }
        alert("\n\
        INVALID ENTRY\n\
        Customer's In-store Purchase:\n\
            - contains book title and its price\n\
            - single space required between the price and book title\n\
            - price formate should be '$0.00'\n\
            - only (1/2) 'Purchase' responses are required\n\
        ");
    }
    else if (input.id == "onlPur" || input.id == "onlPurUpdate") { //online purchase    
        if (/^.+ \$\d+\.\d{2}$/.test(input.value)) {
            return true;
        }
        else if (input.id == "onlPur") {
            if (input.value == "" && /^.+ \$\d+\.\d{2}$/.test(document.getElementById("storePur").value)) {
                return true;
            }
        }
        else if (input.id == "onlPurUpdate") {
            if (input.value == "" && /^.+ \$\d+\.\d{2}$/.test(document.getElementById("storePurUpdate").value)) {
                return true;
            }
        }
        alert("\n\
        INVALID ENTRY\n\
        Customer's Online Purchase:\n\
            - contains book title and its price\n\
            - single space required between the price and book title\n\
            - price format should be '$0.00'\n\
            - only (1/2) 'Purchase' responses are required\n\
        ");
    }
    else if (input.id == "date") { //date
        return true;
    }
    else if (input.id == "payType" || input.id == "orderType") { //pay/order type
        if (document.getElementById("payType").value == "CASH" && document.getElementById("orderType").value == "Online") {
            alert("\n\
                INVALID ENTRY\n\
                Pay Type:\n\
                    - must select option\n\
                    - must be 'Credit' for online purchases\n\
                ");
        }
        else if (input.value == "") {
            if (input.id == "payType") {
                alert("\n\
                INVALID ENTRY\n\
                Pay Type:\n\
                    - must select option\n\
                    - must be 'Credit' for online purchases\n\
                ");
            }
            else if (input.id == "orderType") {
                alert("\n\
                INVALID ENTRY\n\
                Oreder Type:\n\
                    - must select option\n\
                    - must be 'Credit' for online purchases\n\
                ");
            }
        }
        else {
            return true;
        }
    }
    else if (input.id == "cardNum") { //credit card number
        if (/^\d{4} \d{4} \d{4} \d{4}$/.test(input.value) && document.getElementById("payType").value == "CREDIT") {
            return true; 
        }
        else if (input.value == "" && document.getElementById("payType").value == "CASH") {
            return true;
        }
        alert("\n\
        INVALID ENTRY\n\
        Credit Card Number:\n\
            - 4 groups of 4 digits separated by a space\n\
            - consists of 20 characters\n\
            - must be empty for cash purchases\n\
        ");
    }
    else if (input.id == "address") { //date
        if (input.value != "") {
            return true;
        }
        else {
            alert("\n\
            INVALID ENTRY\n\
            Address:\n\
                - must enter valid address\n\
            ");
        }
    }
    else if (input.id == "purId") { //purchase Id
        if (Number.isInteger(parseInt(input.value)) && /^[0-9]{8}$/.test(input.value)) {
            return true;
        }
        else {
            alert("\n\
            INVALID ENTRY\n\
            Customer's Purchase ID:\n\
                - must contain 8 integers\n\
            ");
        }
    }
    
    //return
    return false;
}


//clear user entries
function reset()
{
    //text inputs
    var inputs = document.getElementsByTagName('input');
    for (let i = 0; i < inputs.length; i++) 
    {
        inputs[i].style.backgroundColor = inputColor;
        inputs[i].value = "";
        if (invalidInput == inputs[i]) {
            inputs[i].style.backgroundColor = invalidColor;
        }
    }
    
    //select inputs
    inputs = document.getElementsByTagName('select');
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].value = 0;
    }
    
    //email checkbox
    if (document.getElementById("emailConfirmation")) {
        document.getElementById("emailConfirmation").checked = false;
    }
    
    //highlight invalid input
    if (invalidInput != null) {
        invalidInput.style.backgroundColor = invalidColor;
    }
    
    //date on 'Purchase Form'
    resetDate();
}



// *** MAINTAINANCE FUNCTIONS *** //

//screen resolution asjustment
if (window.innerWidth / window.innerHeight < 1.0) {
    document.getElementById("container").style.zoom = "200%";
    document.getElementsByTagName("body")[0].style.backgroundImage = 'url("libraryShelves3.jpg")';
    document.getElementsByTagName("body")[0].style.backgroundRepeat = 'repeat';
}

//on input hover
window.onmouseover=function(e) {
    for (var i = 0; i < allInputs.length; i++) {
        if (e.target == allInputs[i]) {
            e.target.style.backgroundColor = textColor;
        } 
    }
}

//on input click
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

//on input mouseout
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



