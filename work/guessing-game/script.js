
class guessingGame{
    constructor(){
        this.num = Math.floor(Math.random()*100);
        this.guesses = 0;
        console.log(this.num);
    }

    guess(n){
        this.guesses++;

        // Too high
        if (n > this.num) return 1;

        // Too low
        if (n < this.num)
        {
            const incorrectBox = document.getElementById("wrong");

            incorrectBox.showModal();
            document.querySelector("#wrong button").addEventListener("click", () => {
                incorrectBox.close();
            });
        }

        // On the ball
        if (n == this.num)
        {

            const correctBox = document.getElementById("correct");

            correctBox.showModal();
            document.querySelector("#correct button").addEventListener("click", () => {
                correctBox.close();
            });
            return 0;
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    let game = new guessingGame();

    document.querySelector("input[type=button]").addEventListener("click", () => {
        game.guess(parseInt(document.querySelector("input[type=number]").value));
    });

});