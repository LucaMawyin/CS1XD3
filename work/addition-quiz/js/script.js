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

    console.log(num1, num2)
    console.log(result)
}
