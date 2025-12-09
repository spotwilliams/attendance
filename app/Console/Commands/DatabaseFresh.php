<?php

namespace Cat\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DatabaseFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:fresh-cascade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all listed tables using cascade';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schema = 'public';

        $constraints = DB::select(
            "select con.conname as constraint_name, rel.relname as table_name
             from pg_constraint con
             join pg_class rel on rel.oid = con.conrelid
             join pg_namespace nsp on nsp.oid = con.connamespace
             where nsp.nspname = ?",
            [$schema]
        );

        foreach ($constraints as $constraint) {
            $this->info("Dropping constraint {$constraint->constraint_name} on {$constraint->table_name}...");
            DB::statement(sprintf(
                'alter table %s.%s drop constraint if exists %s cascade;',
                $this->ident($schema),
                $this->ident($constraint->table_name),
                $this->ident($constraint->constraint_name)
            ));
        }

        $indexes = DB::select(
            "select schemaname, indexname
             from pg_indexes
             where schemaname = ?",
            [$schema]
        );

        foreach ($indexes as $index) {
            $this->info("Dropping index {$index->indexname}...");
            DB::statement(sprintf(
                'drop index if exists %s.%s cascade;',
                $this->ident($index->schemaname),
                $this->ident($index->indexname)
            ));
        }

        $tables = DB::select(
            "select schemaname, tablename
             from pg_tables
             where schemaname = ?
               and tablename not like 'pg\\_%'
               and tablename not like 'sql\\_%'",
            [$schema]
        );

        foreach ($tables as $table) {
            $qualified = "{$table->schemaname}.{$table->tablename}";
            $this->info("Dropping table {$qualified}...");
            DB::statement(sprintf(
                'drop table if exists %s.%s cascade;',
                $this->ident($table->schemaname),
                $this->ident($table->tablename)
            ));
        }

        $this->info('Database tables (and related objects) dropped.');

        return 0;
    }

    protected function ident(string $name): string
    {
        return '"' . str_replace('"', '""', $name) . '"';
    }
}

