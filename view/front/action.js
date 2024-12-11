document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".sign-up-form");
    const nom = document.getElementById("nom");
    const prenom = document.getElementById("prenom");
    const role = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");

    form.addEventListener("submit", (e) => {
        // Validate First Name
        if (nom.value.trim() === "") {
            alert("First name is required.");
            nom.focus();
            e.preventDefault();
            return;
        }

        // Validate Last Name
        if (prenom.value.trim() === "") {
            alert("Last name is required.");
            prenom.focus();
            e.preventDefault();
            return;
        }

        // Validate Role
        if (role.value.trim() === "") {
            alert("Role is required.");
            role.focus();
            e.preventDefault();
            return;
        }

        // Validate Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email.value)) {
            alert("Please enter a valid email address.");
            email.focus();
            e.preventDefault();
            return;
        }

        // Validate Password
        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!passwordPattern.test(password.value)) {
            alert("Password must be at least 8 characters long and contain both letters and digits.");
            password.focus();
            e.preventDefault();
            return;
        }

        // Validate Confirm Password
        if (password.value !== confirmPassword.value) {
            alert("Passwords do not match.");
            confirmPassword.focus();
            e.preventDefault();
            return;
        }

        alert("Form submitted successfully!");
    });
});
