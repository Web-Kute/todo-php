<?php
include './config-db.php';
session_start();
$sql = 'SELECT * FROM tasks';
$result = mysqli_query($mysqli, $sql);
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
$taksNumber = mysqli_num_rows($result);
$errors = "";

$tasky = $_POST['addtask'];
if (isset($_POST['submit']) && $_POST['submit'] === "Add") {
  if (!empty($tasky)) {
    $sql = "INSERT INTO `tasks`(`task`) VALUES ('" . $tasky . "')";
    mysqli_query($mysqli, $sql);
    header('Location: index.php');
  } else {
    $errors = "Veuillez ajouter une tâche";
  }
}

// if ($mysqli->query($sql) === TRUE) {
//   echo "New record created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . $mysqli->error;
// }

if (isset($_GET['del_task'])) {
  $id = $_GET['del_task'];
  $sql = "DELETE FROM tasks WHERE `tasks`.`task_id` = $id";
  mysqli_query($mysqli, $sql);
  header('Location: index.php');
}

if (isset($_POST['done'])) {
  $id = $_POST['done'];
  $sql = "UPDATE tasks SET `done`= 1 WHERE `tasks`.`task_id` = $id";
  mysqli_query($mysqli, $sql);
  header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="<KEY>" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>ToDoList</title>
</head>

<body>
  <h1>To Do List</h1>
  <?php if (isset($tasky)) {
    echo "<p>Tâches ajoutées ! " . $taksNumber .  "</p>";
  } ?>
  <div class="error"><?php if (isset($errors)) { ?>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="addtask">Add a task: </label>
        <input type="text" id="addtask" name="addtask">
        <input type="submit" name="submit" value="Add">
      </form>
      <p><?php echo $errors; ?></p>
    <?php } ?>
  </div>
  <ul class="tasks-list">
    <?php
    foreach ($tasks as $task) {
      $checked = $task['done'] === 1 ? 'checked' : 'unchecked';
      echo '<div class="task-item"><input class="checklist" type="checkbox" name="done" value="' . $task['task_id'] . '"' . $checked . '  ><li class="task' . ($task['done'] ? ' done' : '') . '">' . $task['task_id'] . ' ' . $task['task'] . ' </li><a href="index.php?del_task= ' . $task['task_id'] . '">X</a></div>';
      var_dump($task['done']);
    }
    ?>
  </ul>


  <script>
    const checkList = document.querySelector('.checklist');
    document.addEventListener('change', (e) => {
      if (e.target.classList.contains('checklist')) {
        const task = e.target.parentElement;
        task.classList.toggle('done');
        e.target.setAttribute('checked', 'checked');
      }
    });
  </script>

</body>

</html>