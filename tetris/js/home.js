
// Only allow user to enter letters for initials
// Initials can be repeated
function lettersOnly(input) {
    input.value = input.value.replace(/[^a-zA-Z]/g, '');
}

document.addEventListener('keydown', (event) => {
    const key = event.key;
    if (key === 'Enter'){
        play(event);
    }
});

// Only letting user play game if they enter initials
const playBtn = document.getElementById('play-btn');

playBtn.addEventListener('click', (event)=>{
    play(event);
});

function play(event){
    const initials = document.getElementById("player-init");

    if (initials.value === ""){
        alert("Please Enter Initials");
        event.preventDefault();
    }
    else{
        initials.value = "";
        window.location.href = "tetris.html"
    }
}