<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "student_manager";

    //create connection
    $connection = new mysqli($servername, $username, $password, $database);

    //drop down selection for department
    

    $id = "";
    $name = "";
    $email = "";
    $department = "";
    $phone = "";
    $address = "";

    $errorMessage = "";
    $successMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(!isset($_GET["id"])) {
            header("location: /2018COM52/index.php");
            exit;
        }

        $id = $_GET["id"];

        //read a selected student from database
        // $sql = "SELECT * FROM students WHERE id=$id";
        // $result = $connection->query($sql);
        // $row = $result->fetch_assoc();
        // $selectedDepartmentId = $row['depId'];

        // $query = "SELECT * FROM departments";
        // $res = mysqli_query($connection, $query);
        // $options = "";
        // while($row1 = mysqli_fetch_array($res)) {
        //     $options = $options."<option selected=($selectedDepartmentId == $row1[0]) ? 'selected' : ''>$row1[1]</option>";
        // }

        
        $departmentsQuery = "SELECT * FROM departments";
        $departmentsResult = mysqli_query($connection, $departmentsQuery);
        $departments = mysqli_fetch_all($departmentsResult, MYSQLI_ASSOC);

        $studentQuery = "SELECT * FROM students WHERE id = $id";
        $studentResult = mysqli_query($connection, $studentQuery);
        $student = mysqli_fetch_assoc($studentResult);
        $selectedDepartmentID = $student['depId'];


        if(!$student) {
            header("location: /2018COM52/Project/index.php");
            exit;
        }

        $name = $student["name"];
        $email = $student["email"];
        $department = $student["depId"];
        $phone = $student["phone"];
        $address = $student["address"];

    } else {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $department = $_POST["department"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];

        do {
            if(empty($id) || empty($name) || empty($email) || empty($department) || empty($phone) || empty($address)) {
                $errorMessage = "All the fields are required!";
                break;
            }

            $sql = "UPDATE students SET name = '$name', email = '$email', phone = '$phone', address = '$address', depId = '$department' WHERE id=$id";

            $result = $connection->query($sql);

            if(!$result) {
                $errorMessage = "Invalid query : " . $connection->error;
                break;
            }

            $successMessage = "Student is updated successfully";

            header("location: /2018COM52/Project/index.php");
            exit;
        }while(false);

    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Management System</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    </head>

    <body>

        <div class="container my-5">

            <h1 class="text-center mb-5 fw-bold pt-3 pb-3"  style="border: dotted">Student Management System</h1>

            <h2>Edit Student</h2>

            <?php
                    if(!empty($errorMessage)) {
                        echo "
                            <div class='row mb-3'>
                                <div class='offset-sm-3 col-sm-6'>
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        <strong>$errorMessage</strong>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label></button>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                ?>

            <form method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Department</label>
                    <div class="col-sm-6">
                        <!-- <input type="text" class="form-control" name="department" value="/> -->
                        <select name="department">
                            <!-- <?php echo $options; ?> -->
                            <?php foreach ($departments as $department): ?>
                            <option value="<?php echo $department['depId']; ?>" <?php echo           ($selectedDepartmentID == $department['depId']) ? 'selected' : ''; ?>>
                            <?php echo $department['depName']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" />
                    </div>
                </div>

                <?php
                    if(!empty($successMessage)) {
                        echo "
                            <div class='row mb-3'>
                                <div class='offset-sm-3 col-sm-6'>
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        <strong>$successMessage</strong>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label></button>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                ?>

                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a href="/2018COM52/Project/index.php" class="btn btn-outline-primary" role="button">Cancel</a>
                    </div>
                </div>

            </form>
        </div>

    </body> 
</html>