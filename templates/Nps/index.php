<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Screen</title>
    <!-- Add Bootstrap CDN for easier styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS to enlarge text and style the welcome screen -->
    <style>
        body {
            font-size: 1.5rem; /* Base font size */
        }
        .welcome-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .welcome-box {
            background-color: #f8f9fa;
            padding: 3rem;
            border-radius: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 2.5rem; /* Larger heading */
            margin-bottom: 1rem;
        }
        p {
            font-size: 1.8rem; /* Larger body text */
            margin-bottom: 2rem;
        }
        .btn-primary {
            font-size: 1.6rem; /* Enlarge button text */
            padding: 1rem 2rem; /* Increase padding for better spacing */
        }
    </style>
</head>
<body>

<div class="container-fluid welcome-container">
    <div class="welcome-box">
        <h1>Welcome to our Application!</h1>
        <p>We're excited to have you here. Explore and enjoy the experience as you navigate through the application.</p>
    </div>
</div>

<!-- Optional: Add Bootstrap JS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
