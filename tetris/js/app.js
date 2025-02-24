
document.addEventListener('DOMContentLoaded', () => {

    // Forcing user to go through the home screen
    if (!localStorage.getItem('visitedIndex') || localStorage.getItem('player') === null)
    {
        window.location.href = 'index.html';
        localStorage.setItem('visitedIndex', true);
    }
    else
    {
        localStorage.removeItem('visitedIndex');
    }

    // User needs to enter initials every time they play
    let name = localStorage.getItem('player');
    localStorage.removeItem('player');
    let highScores = JSON.parse(localStorage.getItem('highScores'));
    let highNames = JSON.parse(localStorage.getItem('highNames'));


    // HTML elements
    const grid = document.querySelector('.grid');
    const scoreDisp = document.querySelector('#score');
    const levelDisp = document.querySelector('#level');
    const lineDisp = document.querySelector('#lines');
    let squares = Array.from(document.querySelectorAll('.grid div'));
    const miniGrid = document.querySelector('.mini-grid');
    const nextSquares = Array.from(document.querySelectorAll('.mini-grid div'));
    let pauseBtn = document.getElementById('pauseBtn');
    const gameOver = document.getElementsByClassName('game-over')[0];
    const container = document.querySelectorAll('.container');
    
    // Default values
    const MAX_LEVEL = 10;
    let level = 1;
    let dropSpeed = 1000;
    let score = 0;
    let lineCnt = 0;
    let previousLineCnt = 0;
    const width = 10;
    let timerId;
    let paused = false;


    // Creating each tetromino
    // https://docs.google.com/spreadsheets/d/12WR_rgHd6ENNGiIF0RBDOAiI4D1YlewqZecEhn96u74/edit?usp=sharing
    const shape_J = [
        [width, width+1, width+2, (2*width)+2],
        [1, width+1, (2*width)+1, 2*width],
        [width, 2*width, (2*width)+1, (2*width)+2],
        [1, 2, width+1, (2*width)+1]
    ]

    const shape_L = [
        [width, width+1, width+2, 2*width],
        [0, 1, width+1, (2*width)+1],
        [2*width, (2*width)+1, (2*width)+2, width+2],
        [1, width+1, (2*width)+1, (2*width)+2]
    ]

    const shape_S = [
        [width+1, width+2, (2*width), (2*width)+1],
        [0, width, width+1, (2*width)+1],
        [width+1, width+2, (2*width), (2*width)+1],
        [0, width, width+1, (2*width)+1]        
    ]

    const shape_T = [
        [width, width+1, width+2, (2*width)+1],
        [1, width+1, (2*width)+1, width],
        [width+1, (2*width), (2*width)+1, (2*width)+2],
        [1, width+1, (2*width)+1, width+2],
    ]

    const shape_Z = [
        [width, width+1, (2*width)+1, (2*width)+2],
        [2, width+1, width+2, (2*width)+1],
        [width, width+1, (2*width)+1, (2*width)+2],
        [2, width+1, width+2, (2*width)+1]
    ]

    const shape_O = [
        [width+1, width+2, (2*width)+1, (2*width)+2],
        [width+1, width+2, (2*width)+1, (2*width)+2],
        [width+1, width+2, (2*width)+1, (2*width)+2],
        [width+1, width+2, (2*width)+1, (2*width)+2]
    ]

    const shape_I = [
        [width, width+1, width+2, width+3],
        [2, width+2, (2*width)+2, (3*width)+2],
        [width, width+1, width+2, width+3],
        [2, width+2, (2*width)+2, (3*width)+2]
    ]

    // Array of tetrominoes
    const shapes = [shape_L, shape_J, shape_T, shape_S, shape_Z, shape_I, shape_O];
    const colours = ["#ffb700", "#0000ff", "#a000ff", "#00ff00", "#ff0000", "#00ffee", "#ffe900"];

    // Position variables
    let currentPosition;
    let currentBlock;
    let currentRotation;
    let current;
    let nextBlock = Math.floor(Math.random()*shapes.length);
    let nextRotation = Math.floor(Math.random()*shapes[nextBlock].length);
    let nextPiece = shapes[nextBlock][nextRotation];

    // Start game
    spawn();
    showNext();

    // Block generation
    function spawn(){

        // Default spawn of shape at center
        currentPosition = 3;

        // Setting current block to the next block       
        currentBlock = nextBlock;
        currentRotation = nextRotation;

        current = nextPiece;


        // Setting next block
        nextBlock = Math.floor(Math.random()*shapes.length);
        nextRotation = Math.floor(Math.random()*shapes[nextBlock].length);

        nextPiece = shapes[nextBlock][nextRotation];
    }

    // Show block
    function show() {

        current.forEach(index => {
            squares[currentPosition + index].classList.add('tetromino');
            squares[currentPosition + index].style.backgroundColor = colours[currentBlock];
        });
    }

    // Show next block
    function showNext() {
    
        const nextPieceList = [
            [8,9,10,6],  // L
            [8,9,10,4], // J
            [4,5,6,9],  // T
            [5,6,8,9],  // S
            [4,5,9,10],  // Z
            [4,5,6,7],  // I
            [5,6,9,10]   // O
        ];
    
        // Clear mini grid
        nextSquares.forEach(square => {
            square.classList.remove('tetromino');
            square.style.backgroundColor = "grey";
        });
    
        // Get mini display block
        let miniGridPiece = nextPieceList[nextBlock];
    
        // Show next piece in next piece display
        miniGridPiece.forEach(index => {
            nextSquares[index].classList.add('tetromino');
            nextSquares[index].style.backgroundColor = colours[nextBlock];
        });
    }

    // Remove block
    function remove() {
        current.forEach(index => {
            squares[currentPosition + index].style.backgroundColor = "";
            squares[currentPosition + index].classList.remove('tetromino')
        })
    }


    // Moving down
    function down(){

        // If paused go back
        if (paused) return;

        // If not at bottom keep moving
        if (!checkBottom()){
            remove();
            currentPosition += width;
            show();
        }

        // If reached bottom spawn next block
        else
        {
            next();
        }
    }

    // Default drop speed
    timerId = setInterval(down, dropSpeed);

    // Check if block has reached bottom
    function checkBottom() {
        return current.some(index => 
            squares[currentPosition + index + width]?.classList.contains('taken')
        );
    }

    // Next block
    function next() {

        // Turning each untaken square to taken
        current.forEach(index => squares[currentPosition + index].classList.add('taken'));

        spawn();
        showNext();

        clearLine();
        show();
        lose();
         
    }

    // Moving left
    function moveLeft(){
        remove();

        // If any element is at edge then no more moving left
        const edge = current.some(index => (currentPosition + index) % width === 0);
        const collision = current.some(index => squares[currentPosition + index - 1]?.classList.contains('taken'));

        if (!edge && !collision){
            currentPosition -= 1;
        }

        show();
    }

    // Moving right
    function moveRight(){
        remove();

        // If any element is at edge then no more moving left
        const edge = current.some(index => (currentPosition + index) % width === 9)
        const collision = current.some(index => squares[currentPosition + index + 1]?.classList.contains('taken'));

        if (!edge && !collision){
            currentPosition += 1;
        }

        show();
    }

    // Soft drop
    let softDrop;

    // Resetting drop settings
    function unSoftDrop(){
        softDrop = false;

        updateDropSpeed();
    }

    // Rotate clockwise
    function rotateClockwise(){
        remove();

        if (currentRotation === 3){
            currentRotation = 0;
        }
        else{
            currentRotation++;
        }

        current = shapes[currentBlock][currentRotation];

        show();
    }

    // Rotate counter clockwise
    function rotateCounterClockwise(){
        remove();

        if (currentRotation === 0){
            currentRotation = 3;
        }
        else{
            currentRotation--;
        }

        current = shapes[currentBlock][currentRotation];

        show();
    }

    document.addEventListener("keydown", (e) => {

        // Bind escape key to pause
        if (e.key.toLowerCase() === "escape") pauseGame();

        // Only allow stuff to work during unpause time
        if (!paused)
        {
            switch (e.key.toLowerCase())
            {

                // Moving left/right
                case ("a"):
                    moveLeft();
                    break;
                case "arrowleft":
                    moveLeft();
                    break;
                case ("d"):
                    moveRight();
                    break;
                case "arrowright":
                    moveRight();
                    break;

                // Soft dropping
                case("s"):

                    if (!softDrop){

                        softDrop = true;

                        dropSpeed /=10;
                        clearInterval(timerId);
                        timerId = setInterval(down, dropSpeed);                    
                    }
                    break;

                // Rotating
                case ("arrowup"):
                    rotateClockwise();
                    break;
                case ("arrowdown"):
                    rotateCounterClockwise();
                    break;
            }            
        }
    });



    // Soft drop key was released
    document.addEventListener("keyup", (e) => {

        if (e.key.toLowerCase() === "s" && !paused){
            unSoftDrop();
        }
    });


    // User pauses game
    pauseBtn.addEventListener('click', ()=>{
        pauseGame();
    });

    // Pause game
    function pauseGame(){

        // Changing pause button text
        pauseBtn.textContent = paused ? "Pause" : "Resume";

        // Reset soft drop settings
        if (softDrop){
            unSoftDrop();
        }

        // If game is paused then unpause
        if (paused)
        {
            grid.style.display = "flex";
            miniGrid.style.display = "flex";
            timerId = setInterval(down, dropSpeed);
            paused = false;
        }

        // If game is unpaused then pause
        else
        {
            grid.style.display = "none";
            miniGrid.style.display = "none";
            clearInterval(timerId);
            timerId = null;
            paused = true;
        }
    }


    // User clears a line
    function clearLine(){

        let lines = 0;
        let linePoints = 0;
        let softDropPoints = 0;

        // Clear full lines and append to top
        for (let i = 0; i < 200; i += width)
        {
            const row = [i,i+1,i+2,i+3,i+4,i+5,i+6,i+7,i+8,i+9];

            if (row.every(index => squares[index]?.classList.contains('taken')))
            {
                row.forEach(index => {
                    squares[index].style.backgroundColor = "grey";
                    squares[index].classList.remove('taken');
                    squares[index].classList.remove('tetromino');

                    lines++;
                });

                const line = squares.splice(i, width);
                squares = line.concat(squares);
                squares.forEach(cell => grid.appendChild(cell));
            }
        }

        // Lines cleared
        lines /= 10;

        // Update line count
        previousLineCnt = lineCnt;
        lineCnt += lines;

        // Scoring system

        // Line dependent score
        if (lines === 1) 
        {
            linePoints = 40;
        }
        else if (lines === 2)
        {
            linePoints = 100;
        }
        else if (lines === 3) 
        {
            linePoints = 300;
        }
        else if (lines > 3) 
        {
            linePoints = 1200;
        }

        softDropPoints = (linePoints/10);

        // If user soft drops on easy level then -10%
        if (softDrop && level < MAX_LEVEL/2)
        {
            score -= softDropPoints;
        }

        // If user soft drops on harder levels then +10% + (level*20)
        else if (softDrop && level >= MAX_LEVEL/2)
        {
            score += softDropPoints + (level*20);
        }

        score += linePoints;

        scoreDisp.textContent = score;

        // Level up
        if (Math.floor(previousLineCnt / 10) < Math.floor(lineCnt / 10)) {
            level++;
            if (level < MAX_LEVEL)
            {
                updateDropSpeed();
            }
        }

        levelDisp.textContent = level;
        lineDisp.textContent = lineCnt;
    }

    function updateDropSpeed() {

        dropSpeed = 1000 - ((level-1) * 100);
        clearInterval(timerId);
        timerId = setInterval(down, dropSpeed);
    }

    function lose()
    {
        if (current.some(index => squares[currentPosition + index]?.classList.contains('taken')))
        {
            pauseGame();
            clearInterval(timerId);

            document.querySelector('.game-over #score').textContent = score;
            document.querySelector('.game-over #lines').textContent = lineCnt;
            document.querySelector('.game-over #level').textContent = level;

            gameOver.style.display = "flex";
            
            Array.from(container).forEach((element) => {
                element.style.display = "none";
            });

            saveScore();
        }
    }

    function saveScore()
    {
        for (let i = 0; i < highScores.length; i++)
        {
            if (score > highScores[i])
            {
                highScores.splice(i, 0, score);
                highScores.pop();
                highNames.splice(i, 0, name.toUpperCase());
                highNames.pop();
                localStorage.setItem('highScores', JSON.stringify(highScores));
                localStorage.setItem('highNames', JSON.stringify(highNames));
                break;
            }
        }
    }
});