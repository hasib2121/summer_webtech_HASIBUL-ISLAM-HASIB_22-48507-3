<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";    
$password = "";        
$dbname = "testdb";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($sql)) {
    die("Database creation failed: " . $conn->error);
}

$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
)";
if (!$conn->query($sql)) {
    die("Table creation failed: " . $conn->error);
}

if (isset($_POST['Generate'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    if ($name && $email) {
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    if ($id && $name && $email) {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $email, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$editUser = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $editUser = $result->fetch_assoc();
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>DB Connection</title>
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 30px;
        background: #f7f9fc;
    }
    h2 {
        color: #333;
        margin-bottom: 10px;
    }
    form {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    input[type="text"], input[type="email"] {
        padding: 8px;
        width: 240px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right: 10px;
    }
    button {
        padding: 8px 16px;
        background: #4CAF50;
        border: none;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }
    button:hover {
        background: #45a049;
    }
    a {
        text-decoration: none;
        color: #007bff;
        margin-left: 8px;
    }
    a:hover {
        text-decoration: underline;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    th, td {
        border: 1px solid #eee;
        padding: 10px;
        text-align: left;
    }
    th {
        background: #4CAF50;
        color: white;
    }
    tr:nth-child(even) {
        background: #f2f2f2;
    }
    tr:hover {
        background: #eaf2ff;
    }
</style>
</head>
<body>

<h2><?php echo $editUser ? "Edit User" : "Add More Users"; ?></h2>

<form method="post" action="">
    <?php if ($editUser): ?>
        <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>">
    <?php endif; ?>
    <input type="text" name="name" required placeholder="Enter name" value="<?php echo $editUser ? htmlspecialchars($editUser['name']) : ''; ?>">
    <input type="email" name="email" required placeholder="Enter email" value="<?php echo $editUser ? htmlspecialchars($editUser['email']) : ''; ?>">
    <button type="submit" name="<?php echo $editUser ? 'update' : 'Generate'; ?>">
        <?php echo $editUser ? 'Update' : 'Generate'; ?>
    </button>
    <?php if ($editUser): ?>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Cancel</a>
    <?php endif; ?>
</form>

<h2>User List</h2>
<table>
    <tr>
        <th>Serial</th><th>Name</th><th>Email</th><th>Actions</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php $serial = 1; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $serial++; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <a href="?edit=<?php echo $row['id']; ?>"> Edit</a> | 
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"> Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4" style="text-align:center; color:#666;">No users found.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
