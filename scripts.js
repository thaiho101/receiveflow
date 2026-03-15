
// localStorage.setItem("receiveflow_user", name);

function setActiveUser(code) {
    userName = code;
    localStorage.setItem("receiveflow_user", userName);

    fetch("./backend/set_user_session.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "name=" + encodeURIComponent(userName)
    });
}



//Variables
var name = ""; //User name who is working currently
var logged_user_color = "linear-gradient(white, #7FFF00, white)"; //Background color for the logged user
var chosen_user_color = "linear-gradient(white, #87CEFA, white)";
var chosen_user_borderColor = "0.5px inset #87CEFA";
var logging_user_color = "linear-gradient(white, #E0FFFF, white)";
var user_color_normal = "Linear-gradient(white, #e0fcff, white)";
var nameColor = "blue";
var thai = "NH";
var jacob = "JM";
var andy = "AN";


//Position
var title = document.querySelector('#header-nav')

const h1 = document.querySelector('#receiving-nav');
// create a new paragraph element

const current_user_button = document.createElement('button');
//p.style.textAlign = "center";
const div = document.createElement('div');
div.appendChild(current_user_button);
div.style.display = "flex";

//p.style.right = "50px";
div.style.justifyContent = "center";
current_user_button.style.color = "black";
current_user_button.style.background = logged_user_color;
current_user_button.style.border = "0.1px outset lime";
current_user_button.style.borderRadius = "25%";
current_user_button.style.padding = "5px"
div.style.paddingBottom = "10px";

current_user_button.style.display = "none";
// insert the paragraph after the heading
h1.after(div);

//Create a user's button
const loggingUser = document.createElement('button');
loggingUser.innerHTML = "Logging user:".bold();
loggingUser.style.border = "0.5px solid black";
loggingUser.style.position = "absolute";
loggingUser.style.right = "175px";
loggingUser.style.top = "13px";
loggingUser.style.backgroundImage = logging_user_color;
loggingUser.style.borderRadius = "25%";
loggingUser.style.border = "0.5px solid #AFEEEE";

title.appendChild(loggingUser);

//Create a Thai's button
const firstUser = document.createElement('button');
firstUser.classList.add("userButton");

firstUser.innerHTML = thai;
firstUser.style.position = "absolute";
firstUser.style.right = "125px";
firstUser.style.top = "7px";


title.appendChild(firstUser);


//Create a jacob's button
const secondUser = document.createElement('button');
secondUser.classList.add("userButton");
secondUser.innerHTML = jacob;
secondUser.style.position = "absolute";
secondUser.style.right = "75px";
secondUser.style.top = "7px";

title.appendChild(secondUser);

//Create a Andy's button
const thirdUser = document.createElement('button');
thirdUser.classList.add("userButton");
thirdUser.innerHTML = andy;
thirdUser.style.position = "absolute";
thirdUser.style.right = "25px";
thirdUser.style.top = "7px";

title.appendChild(thirdUser);

const allUserButtons = document.querySelectorAll('.userButton');

allUserButtons.forEach(buttons => {
    buttons.addEventListener("click", function() {
        allUserButtons.forEach(btns => {
            btns.style.scale = "1";
            btns.style.border = "0.5px outset #00ffff7c";
            btns.style.webkitTextStroke = "";
        });       
        buttons.style.scale = "1.3";
        buttons.style.border = "0.2px outset #999a9a65";
        buttons.style.webkitTextStroke = ".5px rgba(0, 0, 0, 0.345)";
        // buttons.style.color = "white"
    });
});

firstUser.addEventListener('click', () => {
    name = "NH";

    setActiveUser(name);

    current_user_button.innerHTML = '<span> 👤 Nam Ho</span> is online';
    var nameColor1 = current_user_button.querySelector("span");
    nameColor1.style.color = nameColor;
    firstUser.innerHTML = thai.bold();
    firstUser.style.color = "white"
    firstUser.style.backgroundImage = chosen_user_color;
    // firstUser.style.border = chosen_user_borderColor;

    secondUser.innerHTML = jacob;
    secondUser.style.color = ""
    secondUser.style.backgroundImage = user_color_normal;
    // secondUser.style.border = "0.5px outset #00FFFF";

    thirdUser.innerHTML = andy;
    thirdUser.style.color = ""
    thirdUser.style.backgroundImage = user_color_normal;
    // thirdUser.style.border = "0.5px outset #00FFFF";

    current_user_button.style.display = "block";
    console.log(name);
});



secondUser.addEventListener('click', () => {
    name = "JM";
    
    setActiveUser(name);

    current_user_button.innerHTML = '<span> 👤 Jacob Miller</span> is online';
    var nameColor2 = current_user_button.querySelector("span");
    nameColor2.style.color = nameColor;
    secondUser.innerHTML = jacob.bold();
    secondUser.style.color = "white"
    secondUser.style.backgroundImage = chosen_user_color;
    // secondUser.style.border = chosen_user_borderColor;

    firstUser.innerHTML = thai;
    firstUser.style.color = ""
    firstUser.style.backgroundImage = user_color_normal;
    // firstUser.style.border = "0.5px outset #00FFFF";

    thirdUser.innerHTML = andy;
    thirdUser.style.color = ""
    thirdUser.style.backgroundImage = user_color_normal;
    // thirdUser.style.border = "0.5px outset #00FFFF";

    current_user_button.style.display = "block";
    console.log(name);
});

thirdUser.addEventListener('click', () => {
    name = "AN";

    setActiveUser(name);

    current_user_button.innerHTML = '<span> 👤 Andrew Nolan </span> is online';
    var nameColor3 = current_user_button.querySelector("span");
    nameColor3.style.color = nameColor;

    thirdUser.innerHTML = andy.bold();
    thirdUser.style.color = "white"
    thirdUser.style.backgroundImage = chosen_user_color;
    // thirdUser.style.border = chosen_user_borderColor;

    firstUser.innerHTML = thai;
    firstUser.style.color = ""
    firstUser.style.backgroundImage = user_color_normal;
    // firstUser.style.border = "0.5px outset #00FFFF";

    secondUser.innerHTML = jacob;
    secondUser.style.color = ""
    secondUser.style.backgroundImage = user_color_normal;
    // secondUser.style.border = "0.5px outset #00FFFF";

    current_user_button.style.display = "block";
    console.log(name);
});



const noteArea = document.getElementById('order-note-input');
noteArea.addEventListener('focus', function() {
    var date = new Date();
    var dd = new Date().getDate();
    if (dd < 10) {
    // Plus 0 in front of date which less than 10
    dd = "0" + dd.toString();
    }

    var mm = new Date().getMonth() + 1;
    if (mm < 10) {
    // Plus 0 in front of month which less than 10
    mm = "0" + mm.toString();
    }

    var yyyy = new Date().getFullYear();
    var yy = yyyy.toString().substring(2);
    var today = mm + "/" + dd + "/" + yy;

    let time = date.toLocaleTimeString({"format":"HH:mm"});
    // console.log(time);
    if (noteArea.value === "") {
        noteArea.value += "[" +name + " " + today + " " + time + "]: ";
    } else {
        noteArea.value += "\n\n[" +name + " " + today + " " + time + "]: ";
    }
}, {once: true});


(function restoreUser() {
    const userSaved = localStorage.getItem("receiveflow_user");
    if (!userSaved) return;

    if (userSaved === "NH") firstUser.click();
    if (userSaved === "JM") secondUser.click();
    if (userSaved === "AN") thirdUser.click();
})();










