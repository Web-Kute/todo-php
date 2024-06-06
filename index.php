<?php
include './config-db.php';
session_start();
$sql = 'SELECT * FROM tasks';
$result = mysqli_query($mysqli, $sql);
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
$taksNumber = mysqli_num_rows($result);
$tasky = "";
$errors = $addtaskErr = "";
if (isset($_POST['submit']) && $_POST['submit'] === "Add") {
// Validate input task
if (isset($_POST['addtask'])) {
  $tasky = filter_var($_POST['addtask'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
  echo  $addtaskErr = 'Veuillez ajouter une tâche';
}


// if (isset($_POST['addtask'])) {
//   $tasky = htmlspecialchars($_POST['addtask']);
// }

// Add a task
  if (isset($tasky)) {
    $sql = "INSERT INTO `tasks`(`task`) VALUES ('" . $tasky . "')";
    mysqli_query($mysqli, $sql);
    header('Location: index.php');
    } else {
    $errors = "Veuillez ajouter une tâche";
  }
}

// Delete a task
if (isset($_GET['del_task'])) {
  $id = $_GET['del_task'];
  $sql = "DELETE FROM tasks WHERE `tasks`.`task_id` = $id";
  mysqli_query($mysqli, $sql);
  header('Location: index.php');
}

// Mark a task as done
// if (isset($_POST['done'])) {
//   $id = $_POST['done'];
//   $sql = "UPDATE tasks SET `done`= 1 WHERE `tasks`.`task_id` = $id";
//   mysqli_query($mysqli, $sql);
//   header('Location: index.php');
// }

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
    echo "<p class='error'>Nombre de tâches ! " . $taksNumber .  "</p>";
  } ?>

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
    <label for="addtask">Add a task: </label>
    <input type="text" id="addtask" name="addtask">
    <input type="submit" name="submit" value="Add">
  </form>

  <?php if (isset($errors)) : ?>
    <p class="error"><?php echo $errors; ?></p>
  <?php endif; ?>

  <ul class="tasks-list">
    <?php
    foreach ($tasks as $task) {
      // $checked = $task['done'] === 1 ? 'checked' : 'unchecked';
      echo '<div class="task-item">
            <input class="checklist" type="checkbox" name="done" value="">
              <li class="task' . ($task['done'] ? ' done' : '') . '"> ' . $task['task'] . ' </li>
              <a href="index.php?del_task= ' . $task['task_id'] . '">X</a>
            </div>';
      echo date_format(date_create($task['date']), 'g:ia \o\n l jS F Y');
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
      } else {
        e.target.setAttribute('checked', '');
      }
    });
  </script>

</body>

</html>