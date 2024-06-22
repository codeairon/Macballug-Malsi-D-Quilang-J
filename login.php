
<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<style>
        /* Body styling */
        body {
            
            margin-left: 1000px;
            background-color: #00fc26f1; /* Light blue color */
            margin: 0; /* Remove default margin */
            display: flex;
            flex-direction: column; /* Arrange children in a column */
            align-items: center; /* Center-align children horizontally */
            padding-top: 20px; /* Add some padding at the top for spacing */
            background-image: url('pi/haha.png');
            background-size: cover; /* Cover the entire form with the image */
            background-position: center; /* Center the image within the form */
            background-repeat: no-repeat; /* No repetition of the image */
            opacity: 0.8; /* Adjust opacity if needed to increase legibility */
        }

        /* Form styling */
        form {
            margin-left:500px;
            margin-right: auto;
            width: 100%; /* Full width of the parent container */
            max-width: 330px; /* Maximum width of the form */
            padding: 20px; /* Padding inside the form */
            background-color: rgba(142, 144, 142, 0.845); /* White background for the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
        }

        /* Label styling */
        label {
            color: black; /* Label color */
        }
        input {
            width: 300px;
        }
        /* Title styling */
        h1 {
            margin-left:630px;
            margin-right: auto;
            color: black; /* Title color */
            text-align: center; /* Center-align title */
            margin-bottom: 20px; /* Add space below the title */
        }
        button{
            margin-top: 25px;
            margin-left:100px;
            margin-right: auto;
        }
        label{
            color: black; /* Label color */
        }
    </style>
<body>
    
    <h1>Login</h1>
    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form method="post">
        <label for="email"><h2>Email</h2></label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password"><h2>Password</h2></label>
        <input type="password" name="password" id="password">
        
        <button>Log in</button>
    </form>
    
</body>

</html>

