<?php
// Database config
define('DB_HOST', 'localhost');
define('DB_NAME', 'u900473099_gourav');
define('DB_USER', 'u900473099_gourav');
define('DB_PASS', 'Gourav@9111968788');

// Connect
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Database connection successful.<br><br>";

// Create new admin if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // bcrypt hash
    
    $sql = "INSERT INTO admin_users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "✅ New admin user created successfully.<br><br>";
    } else {
        echo "❌ Error: " . $conn->error . "<br><br>";
    }
}

// Fetch all admins
$result = $conn->query("SELECT id, username FROM admin_users");

if ($result && $result->num_rows > 0) {
    echo "<h3>👥 Admin Users:</h3><ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>ID: " . $row["id"]. " - Username: " . htmlspecialchars($row["username"]) . "</li>";
    }
    echo "</ul>";
} else {
    echo "⚠️ No admin users found.<br>";
}
?>

<!-- Form to create new admin -->
<h3>➕ Create New Admin User</h3>
<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Create Admin</button>
</form>
