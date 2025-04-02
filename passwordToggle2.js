function passwordShow() {
    const togglePassword = document.querySelector('#togglePass1');
    const password = document.querySelector('#password1');
        togglePassword.addEventListener('click', () => {
    // Toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
    // Toggle the eye and bi-eye icon
    this.classList.toggle('bi-eye');
    });
}
passwordShow();


// Reference used from GeeksforGeeks
//https://www.geeksforgeeks.org/how-to-toggle-password-visibility-in-forms-using-bootstrap-icons/