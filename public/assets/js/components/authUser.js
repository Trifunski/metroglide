class AuthUser {
    async submitLogin(email, password) {
        const data = JSON.stringify({ email, password });
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: data
        });

        if (!response.ok) {
            throw new Error('Failed to login');
        }

        const user = await response.json();
        window.location.replace(document.referrer);
        return user;
    }
}

export default AuthUser;