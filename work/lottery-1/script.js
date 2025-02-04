
window.addEventListener("DOMContentLoaded", function(e){
    let colour = "Red"

    // Randomly changing to white
    if (Math.floor(Math.random() * 2)){
        colour = "White"
    }

    let value = Math.floor(Math.random() * 100);

    const ball = {
        colour, 
        value
    };

    alert(`Colour: ${colour}\nValue: ${value}`);
});

document.addEventListener("DOMContentLoaded", () => {

    const btn = document.getElementById("try-again");

    if (btn){
        btn.addEventListener("click", (e) =>{
            location.reload();
        });
    }

});