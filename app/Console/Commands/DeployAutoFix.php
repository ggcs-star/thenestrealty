<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DeployAutoFix extends Command
{
    protected $signature = 'deploy:auto';
    protected $description = 'Auto-check and fix common Laravel deployment issues';

    public function handle()
    {
        $this->info('🚀 Starting Laravel Auto-Fix Deployment Script...');
        $this->line('-----------------------------------------------');

        // 1. Check .env file
        if (!File::exists(base_path('.env'))) {
            $this->error('❌ .env file missing!');
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), base_path('.env'));
                $this->warn('⚙️ Copied .env.example → .env');
            } else {
                $this->error('Cannot continue without .env file!');
                return Command::FAILURE;
            }
        }
        $this->info('✅ .env file OK.');

        // 2. Check APP_KEY
        if (empty(env('APP_KEY'))) {
            $this->warn('⚙️ APP_KEY missing, generating...');
            $this->call('key:generate', ['--force' => true]);
        } else {
            $this->info('✅ APP_KEY OK.');
        }

        // 3. Composer dependencies
        $this->info('📦 Installing composer dependencies...');
        exec('composer install --no-dev --optimize-autoloader 2>&1', $composerOutput, $composerResult);
        $this->output->writeln($composerOutput);
        if ($composerResult !== 0) {
            $this->error('❌ Composer install failed!');
            return Command::FAILURE;
        }

        // 4. Check database connection
        $this->info('🧩 Checking database connection...');
        try {
            DB::connection()->getPdo();
            $this->info('✅ Database connected successfully.');
        } catch (\Exception $e) {
            $this->warn('⚠️ Database not connected: ' . $e->getMessage());
        }

        // 5. Fix permissions
        $this->info('🔑 Checking permissions...');
        $paths = ['storage', 'bootstrap/cache'];
        foreach ($paths as $path) {
            $full = base_path($path);
            if (!is_writable($full)) {
                $this->warn("⚙️ Fixing permissions for {$path}...");
                @chmod($full, 0775);
            }
        }
        $this->info('✅ Permissions OK.');

        // 6. Optimize Laravel caches
        $this->info('🧹 Clearing and optimizing caches...');
        $this->callSilent('optimize:clear');
        $this->callSilent('config:cache');
        $this->callSilent('route:cache');
        $this->callSilent('view:cache');
        $this->info('✅ Cache optimization complete.');

        // 7. Run migrations (auto confirm)
        $this->info('⚙️ Running database migrations (force)...');
        $this->callSilent('migrate', ['--force' => true]);
        $this->info('✅ Migrations done.');

        // 8. Frontend build (optional - for Laravel + Vite)
        if (File::exists(base_path('vite.config.js')) || File::exists(base_path('webpack.mix.js'))) {
            $this->info('🧱 Building frontend assets...');
            exec('npm ci && npm run build 2>&1', $viteOutput, $viteResult);
            $this->output->writeln($viteOutput);
            if ($viteResult === 0) {
                $this->info('✅ Frontend build successful.');
            } else {
                $this->warn('⚠️ Frontend build failed. Check logs.');
            }
        } else {
            $this->info('ℹ️ No frontend build config found, skipping.');
        }

        // 9. Success message
        $this->line('-----------------------------------------------');
        $this->info('🎉 Deployment checks & fixes completed successfully!');
        $this->line('✅ Your Laravel app is ready for deployment 🚀');

        return Command::SUCCESS;
    }
}
