function setInvisible(index, rabbits){

    for (let i = 0; i < 4; i++){
    
        if (i !== index){
            rabbits[i].style.visibility = "hidden";
        }
        else{
            rabbits[i].style.visibility = "visible";
        }
    }
}


const rabbits = Array(4);
let ri = 0;

for (let i = 0; i < 4; i++){
    rabbits[i] = document.getElementById(`rabbit${(i+1)}`);
}
setInvisible(ri, rabbits);


rabbits[ri].addEventListener("mouseover", () => {

    console.log(ri)
    ri = (ri === 3) ? ri = 0 : ri+1;

    setInvisible(ri, rabbits);

    rabbits[ri].addEventListener("mouseover", () => {
        ri = (ri === 3) ? 0 : ri + 1;
        setInvisible(ri, rabbits);
    });
});



