<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Quotation</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 2em auto; line-height: 1.6; }
        .form-group { margin-bottom: 1em; }
        label { display: block; margin-bottom: 0.5em; font-weight: bold; }
        input, select { width: 100%; padding: 0.5em; box-sizing: border-box; }
        button { background-color: #333; color: white; border: none; padding: 0.8em 1.5em; cursor: pointer; border-radius: 4px; }
        #logout-button { background-color: #ab3a45; }
        header { display: flex; justify-content: space-between; align-items: center; }
        .error { color: #d73a49; border: 1px solid #d73a49; background-color: #ffdce0; padding: 1em; border-radius: 4px; }
        .success { color: #22863a; border: 1px solid #22863a; background-color: #f0fff4; padding: 1em; border-radius: 4px; }
    </style>
</head>
<body>

    <header>
        <h1>Get a Quotation</h1>
        <button id="logout-button">Logout</button>
    </header>

    <form id="quotation-form">
        <div class="form-group">
            <label for="age">Ages (comma-separated, e.g., 28,35)</label>
            <input type="text" id="age" name="age" required value="28,35">
        </div>
        <div class="form-group">
            <label for="currency_id">Currency</label>
            <select id="currency_id" name="currency_id" required>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
                <option value="USD">USD</option>
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" required value="2025-10-01">
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" required value="2025-10-30">
        </div>
        <button type="submit">Get Quote</button>
    </form>

    <div id="result" style="margin-top: 2em;"></div>

    <script>
        const quotationForm = document.getElementById('quotation-form');
        const resultDiv = document.getElementById('result');
        const logoutButton = document.getElementById('logout-button');

        // On page load, check for token
        document.addEventListener('DOMContentLoaded', function() {
            if (!sessionStorage.getItem('jwt_token')) {
                window.location.href = '/login';
            }
        });

        logoutButton.addEventListener('click', function() {
            sessionStorage.removeItem('jwt_token');
            window.location.href = '/login';
        });

        quotationForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            resultDiv.innerHTML = '';

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            const errors = [];
            
            const ages = data.age.split(',').map(age => age.trim());
            if (!data.age || ages.length === 0) {
                errors.push('Age field is required.');
            } else {
                for (const age of ages) {
                    const ageNum = Number(age);
                    if (isNaN(ageNum) || ageNum < 18 || ageNum > 70) {
                        errors.push(`Invalid age provided: "${age}". All ages must be a number between 18 and 70.`);
                        break;
                    }
                }
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0); // Set to midnight for accurate comparison
            const startDate = new Date(data.start_date);
            const endDate = new Date(data.end_date);
            
            if (!data.start_date || !data.end_date) {
                errors.push('Start and end dates are required.');
            } else {
                if (startDate < today) {
                    errors.push('Start date cannot be in the past.');
                }
                if (endDate < startDate) {
                    errors.push('End date cannot be before the start date.');
                }
            }
        

            if (errors.length > 0) {
                // If there are validation errors, display them and stop.
                let errorHtml = '<ul class="error">';
                errors.forEach(error => errorHtml += `<li>${error}</li>`);
                errorHtml += '</ul>';
                resultDiv.innerHTML = errorHtml;
                return;
            }
            
            // If validation passes, proceed with the API call.
            const token = sessionStorage.getItem('jwt_token');

            try {
                const response = await fetch('/api/quotation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify(data)
                });
                const responseData = await response.json();
                if (!response.ok) { throw new Error(responseData.message || 'API request failed'); }
                
                const successHtml = `
                    <div class="success">
                        <h3>Quotation Details</h3>
                        <p><strong>Total:</strong> ${responseData.data.total} ${responseData.data.currency_id}</p>
                        <p><strong>Quotation ID:</strong> ${responseData.data.quotation_id}</p>
                    </div>
                `;
                resultDiv.innerHTML = successHtml;

            } catch (error) {
                resultDiv.innerHTML = `<p class="error">Error: ${error.message}</p>`;
            }
        });
    </script>
</body>
</html>