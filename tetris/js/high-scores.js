

document.addEventListener('DOMContentLoaded', () => {


    // Just making sure they go through the home screen
    // Allows page to set up default values if they don't exist
    if (!localStorage.getItem('visited'))
    {
        window.location.href("index.html");
    }

    localStorage.setItem('visited',true);


    // Getting high scores and high score names from local storage
    let highScores = JSON.parse(localStorage.getItem('highScores'));
    let highNames = JSON.parse(localStorage.getItem('highNames'));

    const scoreList = document.querySelectorAll('#high-scores span');

    for (let i = 0; i < highScores.length; i++)
    {
        scoreList[i].textContent = String((i+1)) + ". "+ highNames[i] +": "+ highScores[i];
    }
});


