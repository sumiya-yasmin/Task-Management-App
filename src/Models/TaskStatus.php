<?php
namespace App\TaskManager\Models;
enum TaskStatus: string {
    case ONGOING = 'ongoing';
    case DONE = 'done';
    case CANCELLED = 'cancelled';
}