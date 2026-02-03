<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK MANAGER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl overflow-hidden">
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
                <?php foreach ($tasks as $task): ?>
                    <div class="flex flex-col gap-2 p-4 border rounded-lg hover:bg-gray-50 transition shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex gap-4 items-center justify-between ">
                                <span class="break-all"><?php echo htmlspecialchars($task->getTitle(), ENT_QUOTES, 'UTF-8'); ?></span>
                                <?php if ($task->getStatus()->value === 'ongoing'): ?>
                                    <span class="border-2 border-gray-300 bg-gray-100 p-1 text-xs rounded-lg text-orange-300"> <?php echo $task->getStatus()->value ?> </span>
                                <?php endif; ?>
                            </div>

                            <div class="flex justify-between gap-1">
                                <?php if ($task->getStatus()->value === 'ongoing'): ?>
                                    <div class="hover:bg-gray-100 p-2 rounded-lg">
                                        <a href="index.php?action=done&id=<?php echo $task->getId(); ?>">
                                            <i data-lucide="check" class="w-4 h-4 text-green-700 stroke-[3px]"></i>
                                        </a>
                                    </div>
                                    <div class="hover:bg-gray-100 p-2 rounded-lg">
                                        <a href="index.php?action=cancel&id=<?php echo $task->getId(); ?>">
                                            <i data-lucide="X" class="w-4 h-4 text-red-700 stroke-[4px]"></i>
                                        </a>
                                    </div>

                                <?php else: ?>
                                    <div class="border-2 border-gray-300 bg-gray-100 p-1 text-xs rounded-lg <?php echo ($task->getStatus()->value === 'done') ? 'text-green-500' : 'text-red-500' ?>">
                                        <?php echo $task->getStatus()->value ?>
                                    </div>
                                <?php endif; ?>
                                <div class="hover:bg-red-100 p-2 rounded-lg">
                                    <a href="index.php?action=delete&id=<?php echo $task->getId(); ?>" onclick="return confirm('Are you sure, you want to delete?')">
                                        <i data-lucide="trash" class="w-4 h-4 text-black-700 stroke-[3px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-xs text-orange-300 rounded"> Started: <?php echo $task->getCreatedAt()->format('M j, g:i a'); ?></span>
                            <?php if ($task->getEndAt() !== null): ?>
                                <span class="text-xs text-blue-300 "> Completed: <?php echo $task->getEndAt()->format('M j, g:i a'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <script>
            lucide.createIcons();
        </script>
</body>

</html>