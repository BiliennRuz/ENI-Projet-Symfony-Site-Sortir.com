
let item = document.getElementById("buttonShow");

item.addEventListener("mouseover", show,false);

console.log("yo");

function show()
{  
    //let item = document.getElementById("buttonShow");
   //document.getElementById("buttonShow").className="action-button primary";
   console.log("survol ok");
   item.setAttribute("className", "action-button primary")
}