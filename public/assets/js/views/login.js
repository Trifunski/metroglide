import AuthUser from '../components/authUser.js';

const loginForm = document.querySelector('#loginForm');
const loginEmail = document.querySelector('#email');
const loginPassword = document.querySelector('#password');

loginForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    try {
        const authUser = new AuthUser();
        await authUser.submitLogin(loginEmail.value, loginPassword.value);
    } catch (error) {
        console.error('Error logging in:', error.message);
        alert('Failed to log in. Please try again.');
    }
});