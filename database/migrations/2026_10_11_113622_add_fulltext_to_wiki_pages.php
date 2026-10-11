<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Только для MySQL/MariaDB
        if (DB::connection()->getDriverName() !== 'mysql') return;

        $exists = collect(DB::select("SHOW INDEX FROM wiki_pages WHERE Key_name = 'idx_wiki_search'"))->isNotEmpty();
        if ($exists) return;

        DB::statement('ALTER TABLE wiki_pages ADD FULLTEXT idx_wiki_search (title, excerpt, content)');
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') return;
        try {
            DB::statement('ALTER TABLE wiki_pages DROP INDEX idx_wiki_search');
        } catch (\Throwable $e) {}
    }
};