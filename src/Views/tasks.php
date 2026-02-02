<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK MANAGER</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-xl overflow-hidden">
    <header class="bg-blue-600 p-6 text-white text-center">
            <h1 class="text-3xl font-bold">Task Manager</h1>
            <p class="text-blue-100 mt-1">Organize your workflow</p>
    </header>

<div class="p-6">
<form action="index.php?action=create" method="POST" class="flex gap-2 mb-8">
    <input type="text" name="title" placeholder="What needs to be done?"
       class="flex-1 border-2 border-gray-200 p-3 rounded-lg focus:outline-none focus:border-blue-500 transition-colors" required>
    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
     Add
     </button>
</form>
<div class="space-y-3">
    <?php if (empty($tasks)): ?>
        <p class="text-center text-gray-500 py-10">No Tasks Yet. Add One Above!</p>
    <?php endif; ?>
    <?php foreach($tasks as $task): ?>
        <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 transition shadow-sm">
          <div class="flex gap-4 items-center justify-center ">
             <span><?php echo $task->getTitle(); ?></span>
             <span class="border-2 border-gray-300 bg-gray-100 p-1 text-orange-300"> <?php echo $task->getStatus()->value ?> </span>

          </div>  
    </div>
    <?php endforeach; ?>
</div>
</div>

     
</body>
</html>