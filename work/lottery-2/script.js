
window.addEventListener("DOMContentLoaded", () => {
    
    const ball = new Array(100);

    // Create random array of balls
    function createBall(length){

        for (let i = 0; i < length; i++){

            let colour = "Red"

            if (Math.floor(Math.random() * 2)){
                colour = "White"
            }

            let value = Math.floor(Math.random() * 100);                         

            ball[i] = {
                colour,
                value
            };
        }
    }

    // Check if number exists in hash map
    function picked(nums, newNum){

        // Number is in hash map i.e. was picked
        if (nums.has(newNum)){
            return true;
        }

        // Not in map -> Add to map
        else{
            nums.set(newNum, 1);
            return false
        }
    }

    // Declaring & initializing variables
    createBall(ball.length);
    let score = 0;
    let nums = new Map();
    let i = "";
    let again;

    do{
        i = prompt("Pick a ball from 0 - 99");

        // Check if user pressed cancel or entered invalid input
        // Finna just give a random number
        if (isNaN(parseInt(i))){
            alert("Invalid Input\nRandom Number: " + (i = Math.floor(Math.random() * 100)));
        }

        // Check if number is already picked
        if (picked(nums, i)){
            alert("Number has already been picked");
        }

        // Number is within range
        else if (i >= 0 && i <= 99){

            // Red ball
            if (ball[i].colour == "Red"){
                score -= ball[i].value;
                alert(`${ball[i].colour}\nValue: ${ball[i].value}`);
            }

            // User got white ball
            // Just gonna tell them final score in seperate alert
            else{
                score += ball[i].value;
                alert(`${ball[i].colour}\nValue: ${ball[i].value}\nScore: ${score}`);
                again = confirm("Would you like to go again?");

            }
        }

        // User quits
        else if (i.toLowerCase() === "quit") {
            break;
        }

        // Number is out of range
        else {
            alert("Number out of Range");
        }

    }while (again && ball[i].colour != "Red");

    alert(`Final Score: ${score}`);
});