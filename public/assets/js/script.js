
/*let item = document.getElementById("buttonShow");

item.addEventListener("mouseover", show2,false);*/

console.log("yo");

/*function show(item)
{  
    //let item = document.getElementById("buttonShow");
   //document.getElementById("buttonShow").className="action-button primary";
   console.log("survol ok");
    item = document.getElementsByClassName("action-button second primary");
   item.replace,"action-button second primary";
 
   return item;
}
*/
//Bouton voir une sortie/////////////////////////
let item2=document.getElementsByClassName("action-button second link");

function show2(item2){

    console.log("survol2 ok");
    let item2 = document.getElementsByClassName("action-button second link")
for (var i = 0; i < item2.length; i++) {
if (item2[i].getAttribute("class") === "action-button second link"){
   item2.setAttribute("class", "action-button second primary");
}
return item2;
  }
}

let item3=document.getElementsByClassName("action-button second primary");

function out(item3){ 
    console.log("survol2 ok");
     let item3 = document.getElementsByClassName("action-button second primary")
for (var i = 0; i < item3.length; i++) {
  if (item3[i].getAttribute("class") === "action-button second primary"){
   item3[i].setAttribute("class", "action-button second link");
}
return item3;
  }
}

//Bouton créer une sortie/////////////////////////

let item4=document.getElementsByClassName("action-button second success");

function show3(item4){

   
     item4 = document.getElementsByClassName("action-button second success")
for (var i = 0; i < item4.length; i++) {
  if (item4[i].getAttribute("class") === "action-button second success"){
   item4[i].setAttribute("class", "action-button success");
}
return item4;
  }
}

let item5=document.getElementsByClassName("action-button success");
function out2(item5){
    
    console.log("survol2 ok");
     item5 = document.getElementsByClassName("action-button success")
for (var i = 0; i < item5.length; i++) {
  if (item5[i].getAttribute("class") === "action-button success"){
   item5[i].setAttribute("class", "action-button second success");
}
return item5;
  }
}