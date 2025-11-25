<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeployPrecheck extends Command
{
    protected $signature = 'deploy:check';
    protected $description = 'Run pre-deployment checks and optimizations for Laravel';

    public function handle()
    {
        $this->info('🚀 Starting Laravel Pre-Deployment Check...');
        $this->line('--------------------------------------------');

        // 1. Check .env file
        if (!File::exists(base_path('.env'))) {
            $this->error('❌ Missing .env file!');
            return Command::FAILURE;
        }
        $this->info('✅ .env file found.');

        // 2. Check APP_KEY
        $appKey = env('APP_KEY');
        if (empty($appKey)) {
            $this->warn('⚠️ APP_KEY missing. Generating one...');
            $this->call('key:generate');
        } else {
            $this->info('✅ APP_KEY present.');
        }

        // 3. PHP version check
        $phpVersion = phpversion();
        $this->info("🔹 PHP Version: {$phpVersion}");

        // 4. Composer dependencies
        $this->info('📦 Checking composer dependencies...');
        exec('composer install --no-dev --optimize-autoloader', $output, $result);
        $this->output->writeln($output);
        if ($result !== 0) {
            $this->error('❌ Composer install failed!');
            return Command::FAILURE;
        }

        // 5. Database connection
        $this->info('🧩 Checking database connection...');
        try {
            \DB::connection()->getPdo();
            $this->info('✅ Database connected successfully.');
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed: ' . $e->getMessage());
            return Command::FAILURE;
        }

        // 6. Storage permissions
        $this->info('🔑 Checking storage and cache permissions...');
        $paths = ['storage', 'bootstrap/cache'];
        foreach ($paths as $path) {
            if (!is_writable(base_path($path))) {
                $this->warn("⚠️ Fixing permissions for: {$path}");
                @chmod(base_path($path), 0775);
            }
        }
        $this->info('✅ Permissions OK.');

        // 7. Cache clear & optimize
        $this->info('🧹 Clearing and optimizing caches...');
        $this->call('optimize:clear');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        $this->info('✅ Optimization complete.');

        // 8. Run migrations (optional confirmation)
        if ($this->confirm('Run database migrations before deploy?', true)) {
            $this->call('migrate', ['--force' => true]);
        }

        $this->line('--------------------------------------------');
        $this->info('🎉 Laravel Pre-Deploy Check Completed Successfully!');
        return Command::SUCCESS;
    }
}
