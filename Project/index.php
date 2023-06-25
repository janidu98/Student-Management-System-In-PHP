<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Management System</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="container my-5">
            <h1 class="text-center mb-5 fw-bold pt-3 pb-3"  style="border: dotted">Student Management System</h1>
            <h2>List of Students</h2>
            <a class="btn btn-primary mb-3 mt-3" href="/2018COM52/Project/create.php">New Student</a>
            <br>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Created Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "student_manager";

                        //create connection
                        $connection = new mysqli($servername, $username, $password, $database);

                        //check connection
                        if($connection->connect_error) {
                            die("Connection failed : " . $connection->connect_error);
                        }

                        //read all row from database table
                        $sql = "SELECT students.id,students.name,departments.depName,students.email,students.phone,students.address,students.created_at FROM students JOIN departments ON students.depId = departments.depId;";
                        $result = $connection->query($sql);

                        //check result has error or not
                        if(!$result) {
                            die("Invalid query : " . $connection->error);
                        }

                        //read data 
                        while($row = $result->fetch_assoc()) {
                            echo "
                                <tr>
                                    <td>$row[id]</td>
                                    <td>$row[name]</td>
                                    <td>$row[depName]</td>
                                    <td>$row[email]</td>
                                    <td>$row[phone]</td>
                                    <td>$row[address]</td>
                                    <td>$row[created_at]</td>
                                    <td>
                                        <a class='btn btn-primary btn-sm' href='/2018COM52/Project/edit.php?id=$row[id]'>Edit</a>
                                        <a class='btn btn-danger btn-sm' href='/2018COM52/Project/delete.php?id=$row[id]'>Delete</a>
                                    </td>
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
    </body>

</html>