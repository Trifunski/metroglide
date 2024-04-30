import APIHandler from "../api/apiHandler.js";

class AuthUser {
    
    constructor() {
        this.api = new APIHandler('');
    }

    async submitLogin(email, password) {
        try {
            const response = await this.api.login(email, password);

            if (response.email) {
                alert(response.email);
            }

            if (response.password) {
                alert(response.password);
            }

            window.location.href = '/';
        } catch (error) {
            alert('Failed to log in: ' + error.message);
        }
    }

}

export default AuthUser;
