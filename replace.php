<?php
$files = array_merge(
    glob('app/Http/Controllers/Admin/*.php'),
    glob('resources/views/admin/events/*.blade.php'),
    glob('resources/views/admin/categories/*.blade.php')
);

foreach ($files as $file) {
    if (is_file($file)) {
        $content = file_get_contents($file);
        $content = str_replace(
            ['organizer.events', 'organizer.categories', 'organizer/events', 'organizer/categories', 'organizer.dashboard'],
            ['admin.events', 'admin.categories', 'admin/events', 'admin/categories', 'admin.dashboard'],
            $content
        );
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
echo "Done\n";
