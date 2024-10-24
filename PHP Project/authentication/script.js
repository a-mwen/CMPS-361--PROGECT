document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector('.login-form');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        // Retrieve the values
        const username = loginForm.querySelector('input[type="text"]').value;
        const password = loginForm.querySelector('input[type="password"]').value;

        // Process the login (add your authentication logic here)
        // Example: Assuming the login is successful
        console.log("Username:", username);
        console.log("Password:", password);

        // Clear the input fields
        loginForm.querySelector('input[type="text"]').value = '';
        loginForm.querySelector('input[type="password"]').value = '';

        // Redirect or refresh the page
        window.location.href = 'welcome.html'; // Redirect to the welcome page
        // Or if you want to refresh the current page, use:
        // location.reload(); // Uncomment this line to refresh the page
    });
});