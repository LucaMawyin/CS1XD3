
class guessingGame{
    constructor(){
        this.load();
    }

    reset() {
        this.num = Math.floor(Math.random() * 100);
        this.guesses = 0;
        this.updateUI();
        this.save();
        console.log(`New number: ${this.num}`);
    }

    save() {
        const state = {
            num: this.num,
            guesses: this.guesses
        };
        localStorage.setItem('guessingGameState', JSON.stringify(state));
    }

    load() {
        const savedState = localStorage.getItem('guessingGameState');
        if (savedState) {
            const state = JSON.parse(savedState);
            this.num = state.num;
            this.guesses = state.guesses;
            document.getElementById("loaded").showModal();
            document.querySelector("#loaded button").addEventListener("click", () => {
                document.getElementById("loaded").close();
            });
            this.updateUI();
        } else {
            this.reset();
        }
    }

    updateUI() {
        const guessCountBox = document.getElementById("guess-count");
        guessCountBox.textContent = `Guesses ${this.guesses}/10`;
    }

    guess(n) {
        if (isNaN(n)) return;

        this.guesses++;
        this.save();

        const guessCountBox = document.getElementById("guess-count");
        const incorrectBox = document.getElementById("wrong");
        const correctBox = document.getElementById("correct");
        const loseBox = document.getElementById("lose");

        document.querySelector("#wrong button").addEventListener("click", () => {
            incorrectBox.close();
        });
        document.querySelector("#correct button").addEventListener("click", () => {
            correctBox.close();
            this.reset();
        });
        document.querySelector("#lose button").addEventListener("click", () => {
            loseBox.close();
            this.reset();
        });

        // Losing condition
        if (this.guesses === 10 && n !== this.num) {
            guessCountBox.textContent = `Guesses ${this.guesses}/10`;
            loseBox.showModal();
            return;
        }

        // Too high
        if (n > this.num) {
            incorrectBox.querySelector("p").textContent = "Too High";
            incorrectBox.showModal();
            guessCountBox.textContent = `Guesses ${this.guesses}/10`;
            return;
        }

        // Too low
        if (n < this.num) {
            incorrectBox.querySelector("p").textContent = "Too Low";
            incorrectBox.showModal();
            guessCountBox.textContent = `Guesses ${this.guesses}/10`;
            return;
        }

        // Correct guess
        if (n === this.num) {
            correctBox.showModal();
            return;
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    let game = new guessingGame();

    document.querySelector("input[type=button]").addEventListener("click", () => {
        game.guess(parseInt(document.querySelector("input[type=number]").value));
    });

});