
/*let item = document.getElementById("buttonShow");*/

//item2.addEventListener("mouseover", show2,false);

console.log("yo");


// //Bouton voir une sortie/////////////////////////
// let item2=document.getElementsByClassName("action-button second link");

// function show2(item2){
   
//     console.log("survol0 ok");
//     item2 = document.getElementsByClassName("action-button second link");
// for (var i = 0; i < item2.length; i++) {
// if (item2[i].getAttribute("class") === "action-button second link"){
//    item2[i].setAttribute("class", "action-button second primary");
// }
// return item2;
//   }
// }

// let item3=document.getElementsByClassName("action-button second primary");
// //item3.addEventListener("mouseover", out,false);

// function out(item3){ 
//     console.log("survol1 ok");
//       item3 = document.getElementsByClassName("action-button second primary");
// for (var i = 0; i < item3.length; i++) {
//   if (item3[i].getAttribute("class") === "action-button second primary"){
//    item3[i].setAttribute("class", "action-button second link");
// }
// return item3;
//   }
// }


//Bouton créer une sortie/////////////////////////

let item4=document.getElementsByClassName("action-button second success");
//item4.addEventListener("mouseover", show3,false);
function show3(item4){
    console.log("survol3 ok");
   
     item4 = document.getElementsByClassName("action-button second success");
for (var i = 0; i < item4.length; i++) {
  if (item4[i].getAttribute("class") === "action-button second success"){
   item4[i].setAttribute("class", "action-button success");
}
return item4;
  }
}

let item5=document.getElementsByClassName("action-button success");
//item5.addEventListener("mouseover", out2,false);
function out2(item5){
    
    console.log("survol4 ok");
     item5 = document.getElementsByClassName("action-button success")
for (var i = 0; i < item5.length; i++) {
  if (item5[i].getAttribute("class") === "action-button success"){
   item5[i].setAttribute("class", "action-button second success");
}
return item5;
  }
}

////////BOUTON VOIR LES FILTRES/////////////


let btn1 = document.getElementById("btn1");
document.getElementById ("btn1").addEventListener ("click", btn, false);
function btn(){
  console.log("j'entre dans la recherche");
  let d1 = document.getElementById("d1");
if(getComputedStyle(d1).display != "block"){
    //d1.setAttribute("style","display:block");
    d1.style.display = "block";
    btn1.setAttribute("class","btn action-button second rotate link");
}
}
document.getElementById ("btn1").addEventListener ("dblclick", btn2, false);
function btn2(){
  let d2 = document.getElementById("d1");
if(getComputedStyle(d1).display != "none"){
  d2.style.display = "none";
    btn1.setAttribute("class","btn action-button second rotate primary");
}

}
/*btn1.addEventListener("click", () => {
  console.log("louche");
  if(getComputedStyle(d1).display != "block"){
    d1.style.display = "block";
  } else {
    d1.style.display = "none";
  }
})
function btn(){
  if(getComputedStyle(d1).display != "block"){
    d1.style.display = "block";
  } else {
    d1.style.display = "none";
  }
};
btn1.onclick = btn;*/