document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll("input[type=number]").forEach(input => input.addEventListener("input", run));
    document.querySelector("#operation").addEventListener("input",run);
    run();
});

function run(){
    let op = document.querySelector("#operation").value;
    
    let num1 = parseInt(document.querySelectorAll("input[type=number]")[0].value);
    let num2 = parseInt(document.querySelectorAll("input[type=number]")[1].value);
    let result = 0;

    switch(op){
        case "+":
            result = num1 + num2;
            break;
        case "-":
            result = num1 - num2;
            break;
        case "*":
            result = num1 * num2;
            break;
        case "/":
            result = num1 / num2;
            break;
        case "%":
            result = num1 % num2;
            break;
    }

    document.querySelectorAll("input[type=text]")[0].value = result;
}
