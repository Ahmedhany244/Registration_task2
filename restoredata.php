<?php
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userId = intval($userId);

    
}
 $conn = new mysqli("localhost", "root", "", "website_users");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();

    if ($userResult->num_rows !== 1) {
        echo "User not found.";
        exit();
    }

    $user = $userResult->fetch_assoc();
    $stmt->close();
    $stmtHobbies = $conn->prepare("SELECT hobbyname FROM user_hobbies WHERE userid = ?");
    $stmtHobbies->bind_param("i", $userId);
    $stmtHobbies->execute();
    $resultHobbies = $stmtHobbies->get_result();

    $userHobbies = [];
    while ($row = $resultHobbies->fetch_assoc()) {
        $userHobbies[] = $row['hobbyname'];
    }

    $stmtHobbies->close();
    $conn->close();

    ?>
<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <style>
        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            max-width: 400px;
        }
    </style>
</head>
<body>
<?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
    <div class="success-message">Data updated successfully!</div>
<?php endif; ?>
<h2>Update User Information</h2>

<form action="update.php?id=<?php echo urlencode($userId); ?>" method="post">

    

    Full Name:
    <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>">
    <br><br>

    Email:
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
    <br><br>
    Password:
    <input type="password" name="password" placeholder="Enter new password or leave blank">
    <br><br>

    Confirm Password:
    <input type="password" name="confirmpassword" placeholder="Confirm new password">
    <br><br>

    Gender:
    <input type="radio" name="gender" value="Male" <?php if ($user['gender'] == 'Male') echo 'checked'; ?>> Male
    <input type="radio" name="gender" value="Female" <?php if ($user['gender'] == 'Female') echo 'checked'; ?>> Female
    <br><br>
    Hobbies:<br>
    <input type="checkbox" name="Hobbies[]" id="reading" value="reading" <?php if (in_array('reading', $userHobbies)) echo 'checked'; ?>>
    <label for="reading">Reading</label><br>

    <input type="checkbox" name="Hobbies[]" id="traveling" value="traveling" <?php if (in_array('traveling', $userHobbies)) echo 'checked'; ?>>
    <label for="traveling">Traveling</label><br>

    <input type="checkbox" name="Hobbies[]" id="sports" value="sports" <?php if (in_array('sports', $userHobbies)) echo 'checked'; ?>>
    <label for="sports">Sports</label>
    <br>

    Country:
    <select name="country">
        <option value="Egypt" <?php if ($user['country'] == 'Egypt') echo 'selected'; ?>>Egypt</option>
        <option value="USA" <?php if ($user['country'] == 'USA') echo 'selected'; ?>>USA</option>
        <option value="France" <?php if ($user['country'] == 'France') echo 'selected'; ?>>France</option>
    </select>
    <br><br>

    <input type="submit" value="Update">
</form>

</body>
</html>

    

