
// Forcing user to home screen
document.addEventListener('DOMContentLoaded', () => {
    localStorage.setItem('visitedIndex',true);

    setLeaderboard();

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

});

// Only allow user to enter letters for initials
// Initials can be repeated
function lettersOnly(input) {
    input.value = input.value.replace(/[^a-zA-Z]/g, '');
}


function play(event){
    const initials = document.getElementById("player-init");

    if (initials.value === ""){
        alert("Please Enter Initials");
        event.preventDefault();
    }
    else{
        localStorage.setItem("player", initials.value);
        initials.value = "";
        window.location.href = "tetris.html"
    }
}

function setLeaderboard(){
    // Set default high scores and names on load if none exist
    if (!localStorage.getItem('highScores') || !localStorage.getItem('highNames')){
        let defaultScores = [1000,900,800,700,600,500,400,300,200,100];
        let defaultNames = ["AAA","BBB","CCC","DDD","EEE","FFF","GGG","HHH","III","JJJ"];
        localStorage.setItem('highScores', JSON.stringify(defaultScores));
        localStorage.setItem('highNames', JSON.stringify(defaultNames));
    }
}