<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ tenant('id') }} Project</title>
</head>
<body>
    <div style="text-align: center; margin-top: 100px;">
        <h1>Welcome to {{ tenant('id') }}</h1>
        <p>This is the public landing page for this project.</p>

        <a href="/login">Login to Dashboard</a> |
        <a href="/register">Register New User</a>
    </div>
</body>
</html>
