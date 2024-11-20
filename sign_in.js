document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form[action='index_inc.php']");
    const passwordInput = document.getElementById("password");
    const errorMessage = document.getElementById("error-message");

    form.addEventListener("submit", (e) => {
        const password = passwordInput.value;

        // Regex to check if the password has both letters and digits, and at least 8 characters
        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (!passwordPattern.test(password)) {
            e.preventDefault(); // Prevent form submission
            errorMessage.textContent = "Password must be at least 8 characters long and contain both letters and digits.";
        } else {
            errorMessage.textContent = ""; // Clear the error message
        }
    });
});
