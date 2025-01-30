
// Animation delay for splash page nav links
document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll("#main-nav a");

    links.forEach((link,index) => {
        setTimeout(() => {
            link.style.animationDelay = `${index * 500}ms`;
        }, index * 500);
    });
});


// Changing themes
const githubImg = document.getElementById("github-img");
const toggleSwitch = document.getElementById("check");

document.addEventListener("DOMContentLoaded", () => {
    // Check if there is a saved theme in local storage
    const savedTheme = localStorage.getItem('theme');

    // If saved theme is dark then apply dark
    if (savedTheme === 'dark') {
        document.body.classList.add("dark-mode");
        document.body.classList.remove("light-mode");

        if (githubImg) {
            githubImg.src = "images/github-light.png";
        }

        // Match switch to respective theme
        if (toggleSwitch) {
            toggleSwitch.checked = true;
        }

    // If theme is light then apply light
    } else {
        document.body.classList.add("light-mode");
        document.body.classList.remove("dark-mode");

        if (githubImg) {
            githubImg.src = "images/github-dark.png";
        }

        // Match switch to respective theme
        if (toggleSwitch) {
            toggleSwitch.checked = false;
        }
    }

    function checkToggle() {

        githubImg.style.opacity = 0;

        setTimeout(() => {
            if (toggleSwitch.checked) {

                document.body.classList.add("dark-mode");
                document.body.classList.remove("light-mode");

                githubImg.src = "images/github-light.png";

                localStorage.setItem('theme', 'dark');

            } else {
                document.body.classList.remove("dark-mode");
                document.body.classList.add("light-mode");

                githubImg.src = "images/github-dark.png";

                localStorage.setItem('theme', 'light');
            }
        }, 100);


        githubImg.style.opacity = 1;
    }

    if (toggleSwitch) {
        toggleSwitch.addEventListener("change", checkToggle);
    }

});