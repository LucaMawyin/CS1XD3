

document.addEventListener('DOMContentLoaded', () => {

    let highScores = JSON.parse(localStorage.getItem('highScores'));
    let highNames = JSON.parse(localStorage.getItem('highNames'));

    const scoreList = document.querySelectorAll('#high-scores span');

    for (let i = 0; i < highScores.length; i++)
    {
        console.log(scoreList[i]);
        scoreList[i].textContent = String((i+1)) + ". "+ highNames[i] +": "+ highScores[i];
    }
});


