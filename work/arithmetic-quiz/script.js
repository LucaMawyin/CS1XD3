
window.addEventListener("load", function (e){
    let yes_no;

    do{

        // Setting numbers
        let num1 = Math.floor(Math.random() * 201) - 100;
        let num2 = Math.floor(Math.random() * 201) - 100;
        let eq = Math.floor(Math.random() * 3);

        let response;
        let ans;
        let q;

        // Setting equation and prompt
        switch (eq) {

            // Addition
            case 0: 
                ans = num1 + num2;
                q = `${num1} + ${num2}`;
                break;

            // Subtraction
            case 1:
                ans = num1 - num2;
                q = `${num1} - ${num2}`;
                break;

            // Multiplication
            case 2:
                ans = num1 * num2;
                q = `${num1} * ${num2}`;
                break;
        }

        response = prompt(`What is ${q}: `);

        while (isNaN(response) || response === null){
            alert("Invalid Input")
            response = prompt(`What is ${q}: `);
        }

        if (parseInt(response) == ans){
            alert("CORRECT!");
        }

        else{
            alert(`Sorry, the answer is ${ans}`);
        }

        yes_no = confirm("Would you like to play again?");
        
    }while (yes_no);
});