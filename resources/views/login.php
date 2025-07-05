<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 4em auto; line-height: 1.6; }
        .form-group { margin-bottom: 1em; }
        label { display: block; margin-bottom: 0.5em; font-weight: bold; }
        input { width: 100%; padding: 0.5em; box-sizing: border-box; }
        button { background-color: #333; color: white; border: none; padding: 0.8em 1.5em; cursor: pointer; border-radius: 4px; }
        .error { color: #d73a49; margin-top: 1em; }
    </style>
</head>
<body>

    <h1>Login</h1>

    <form id="login-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="tester@example.com">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required value="password">
        </div>
        <button type="submit">Login</button>
    </form>

    <div id="result"></div>

    <script>
        const loginForm = document.getElementById('login-form');
        const resultDiv = document.getElementById('result');

        loginForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            resultDiv.innerHTML = '';

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const responseData = await response.json();

                if (!response.ok) {
                    throw new Error(responseData.error || 'Login failed.');
                }

                // Storing the token in the browser's session storage
                sessionStorage.setItem('jwt_token', responseData.access_token);

                // Redirecting to the main quotation form page
                window.location.href = '/';

            } catch (error) {
                resultDiv.innerHTML = `<p class="error">${error.message}</p>`;
            }
        });
    </script>
</body>
</html>