 <table>
        <caption>
            <h1>User Data List</h1>
        </caption>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Hobbies</th>
                <th>Country</th>
                <th>Modify</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $conn=new mysqli("localhost","root","");
        $conn->select_db("website_users");
         $sql = "
        SELECT 
            users.id,
            users.fullname,
            users.email,
            users.gender,
            users.country,
            GROUP_CONCAT(user_hobbies.hobbyname SEPARATOR ', ') AS hobbies
        FROM users
        LEFT JOIN user_hobbies ON users.id = user_hobbies.userid
        GROUP BY users.id
    ";
    $result=$conn->query($sql);
    if ($result&&$result->num_rows>0){
        while ($row = $result->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['hobbies']) . "</td>";
            echo "<td>" . htmlspecialchars($row['country']) . "</td>";
            echo '<td><a href="restoredata.php?id=' . urlencode($row['id']) . '">Edit</a></td>';
            echo "</tr>";
        }
    }
        


        ?>
