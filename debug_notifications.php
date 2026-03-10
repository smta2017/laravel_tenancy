<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$notifications = DB::connection('mysql')->table('notifications')->get();
echo "Central Database Notifications:\n";
foreach ($notifications as $n) {
    echo "ID: {$n->id}, Type: {$n->notifiable_type}, ID: {$n->notifiable_id}, Data: {$n->data}\n";
}

$user = \App\Models\CentralUser::find(1);
if ($user) {
    echo "\nCentral User 1 found: " . get_class($user) . "\n";
    echo "Unread count via relationship: " . $user->unreadNotifications()->count() . "\n";
} else {
    echo "\nCentral User 1 NOT found.\n";
}
