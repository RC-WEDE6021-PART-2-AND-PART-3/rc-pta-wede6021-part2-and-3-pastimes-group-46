 <?php include('database.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Team Table</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" type='text/css'>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_users.php">Users</a></li>
            <!-- Add more navigation links as needed -->
        </ul>
    </nav>

    <div class="body">
        <article class="table-widget">
            <div class="caption">
                <h2>Users</h2>
                
            </div>
            <div id="alerts">
                <?php
                session_start();
                if (isset($_SESSION["create"]) || isset($_SESSION["update"]) || isset($_SESSION["delete"])) {
                    $alerts = ["create", "update", "delete"];
                    foreach ($alerts as $alert) {
                        if (isset($_SESSION[$alert])) {
                            echo "<div class='alert alert-success'>" . $_SESSION[$alert] . "</div>";
                            unset($_SESSION[$alert]);
                        }
                    }
                }
                ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Names</th>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Email Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="team-member-rows">
                    <?php
                   
                    $sqlSelect = "SELECT * FROM tbluser";
                    $result = mysqli_query($mysqli, $sqlSelect);
                    while ($data = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td class="team-member-profile">
                                <div class="profile-info">
                                    <div class="profile-info__name"><?php echo $data['name']; ?></div>
                                    <div class="profile-info__alias"><?php echo $data['id']; ?></div>
                                </div>
                            </td>
                            <td><?php echo $data['id']; ?></td>
                            <td>
                                <div class="status">
                                    
                                    <div class="status__circle status--active"></div>
                                    vefifed
                                </div>
                            </td>
                            <td><?php echo $data['Email']; ?></td>

                            <td>
                                <div class="tags">
                                    <div class="tag tag--marketing">
                                        <a href="view.php?id=<?php echo $data['id']; ?>" class="btn btn-info">verify</a>
                                    </div>
                                    <div class="tag tag--marketing">
                                        <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-warning">Edit</a>
                                    </div>
                                    <div class="tag tag--marketing">
                                        <a href="delete.php?id=<?php echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </article>
    </div>
    <script src="script.js"></script>
</body>

</html>
