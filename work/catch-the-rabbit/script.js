function setInvisible(index, rabbits){

    for (let i = 0; i < rabbits.length; i++){
        rabbits[i].style.visibility = (i !== index) ? "hidden" : "visible";
    }
}

window.addEventListener("DOMContentLoaded", () => {

    // Flexibility for number of rabbits
    const rabbits = Array(4);
    let ri = 0;
    let count = 0;

    for (let i = 0; i < rabbits.length; i++){
        rabbits[i] = document.getElementById(`rabbit${(i+1)}`);

        // Setting listener for each rabbit
        rabbits[i].addEventListener("mouseover", () =>{

            // Resetting index if it's at the end
            ri = (ri === rabbits.length-1) ? 0 : ri+1;
            setInvisible(ri,rabbits);
            count++;

            // Taunts
            if (count === 4){
                document.getElementById("noeggs").style.visibility = "visible";
            }
            else if (count === 20){
                document.getElementById("slow").style.visibility = "visible";
                document.getElementById("noeggs").style.visibility = "hidden";
            }
        });
    }

    // Starting point
    setInvisible(ri,rabbits);
    document.getElementById("noeggs").style.visibility = "hidden";
    document.getElementById("slow").style.visibility = "hidden";
});



