<!-- Connecting to Database -->
<?php

$servername = "localhost";
$username = "root";
$pass = "";
$database = "dbsourav";

$insert = false;
$update = false;
$delete = false;
try {
    // CONNECTING WITH SQL
    $conn = mysqli_connect($servername, $username, $pass, $database);

    if (isset($_GET['delete'])) {
        $sno = $_GET['delete'];
        $deleteSql = "DELETE from `notes` WHERE `sno`=$sno";
        $result = mysqli_query($conn, $deleteSql);
        $delete = true;
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['snoEdit'])) {
            // Update the record
            $sno = $_POST["snoEdit"];
            $title = $_POST["titleEdit"];
            $description = $_POST["descriptionEdit"];
            $updateSql = "UPDATE `notes` SET `title` = '$title',`description`='$description' WHERE `sno` = $sno";
            $result = mysqli_query($conn, $updateSql);
            $update = true;
        } else {
            // Insert the record
            $title = $_POST["title"];
            $description = $_POST["description"];
            $insertSql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description');";
            $result = mysqli_query($conn, $insertSql);

            if ($result) {
                $insert = true;
            }
        }
    }
} catch (Exception $e) {
    die($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/php/notesApp/index.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="titleEdit" class="form-label">Title</label>
                            <input type="text" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="descriptionEdit" class="form-label">Description</label>
                            <textarea name="descriptionEdit" class="form-control" id="descriptionEdit" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success! </strong> Your note has been added successfully
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    } else if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success! </strong> Your note has been updated successfully
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    } else if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success! </strong> Your note has been deleted successfully
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>

    <div class="container mt-3">
        <h2>Add a Note</h2>
        <form action="/php/notesApp/index.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" cols="30" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container mt-3">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S. No.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $sql = "SELECT * from notes";
                    $result = mysqli_query($conn, $sql);
                    $sno = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td><button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['sno'] . ">Delete</button></td>
                    </tr>";
                        $sno++;
                    }
                } catch (Exception $e) {
                    echo "Error!";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

<script>
    var editModal = new bootstrap.Modal(document.getElementById('editModal'))

    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener('click', (e) => {
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName('td')[0].innerText;
            description = tr.getElementsByTagName('td')[1].innerText;
            snoEdit.value = e.target.id;
            titleEdit.value = title;
            descriptionEdit.value = description;

            // Toggle the Modal
            editModal.toggle()
        })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener('click', (e) => {
            sno = e.target.id.substr(1, );
            if (confirm('Do you really want to delete this note')) {
                window.location = `/php/notesApp/index.php?delete=${sno}`;
            }
        })
    })
</script>
</html>