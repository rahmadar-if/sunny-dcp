<?php
/**
 * Solaris Production Installer
 * @author Romadan Saputra <hi.madan27@gmail.com>
 */

echo "\n";
echo '
 $$$$$$\            $$\                     $$\           
$$  __$$\           $$ |                    \__|          
$$ /  \__| $$$$$$\  $$ | $$$$$$\   $$$$$$\  $$\  $$$$$$$\ 
\$$$$$$\  $$  __$$\ $$ | \____$$\ $$  __$$\ $$ |$$  _____|
 \____$$\ $$ /  $$ |$$ | $$$$$$$ |$$ |  \__|$$ |\$$$$$$\  
$$\   $$ |$$ |  $$ |$$ |$$  __$$ |$$ |      $$ | \____$$\ 
\$$$$$$  |\$$$$$$  |$$ |\$$$$$$$ |$$ |      $$ |$$$$$$$  |
 \______/  \______/ \__| \_______|\__|      \__|\_______/'."\n\n";

echo "--- SOLARIS PRODUCTION INSTALLER ---\n\n";

if (file_exists('.env')) {
	echo "The .env file already exists. Overwrite? (y/n) [n]: ";
	$overwrite = trim(fgets(STDIN));
	if (strtolower($overwrite) === 'y') {
		if (file_exists('.env.example')) {
			copy('.env.example', '.env');
		}
		setupEnv();
	}
} else {
	if (file_exists('.env.example')) {
		copy('.env.example', '.env');
	} else {
		// Fallback only if .env.example is somehow missing
		file_put_contents('.env', "APP_NAME=Solaris\nAPP_ENV=production\nAPP_KEY=\nAPP_DEBUG=false\nAPP_URL=http://localhost\n\nDB_CONNECTION=mysql\nDB_HOST=127.0.0.1\nDB_PORT=3306\nDB_DATABASE=solaris\nDB_USERNAME=root\nDB_PASSWORD=\n");
	}
	setupEnv();
}

function setupEnv() {
	$env = file_get_contents('.env');

	// Mirror the same defaults as sandbox setup
	$env = str_replace('SESSION_DRIVER=database', 'SESSION_DRIVER=redis', $env);
	$env = str_replace('QUEUE_CONNECTION=database', 'QUEUE_CONNECTION=redis', $env);
	$env = str_replace('CACHE_STORE=database', 'CACHE_STORE=redis', $env);
	$env = str_replace('REDIS_CLIENT=phpredis', 'REDIS_CLIENT=predis', $env);
	$env = str_replace('BROADCAST_CONNECTION=reverb', 'BROADCAST_CONNECTION=log', $env);
	$env = preg_replace('/^APP_URL=.*$/m', 'APP_URL=http://localhost:8000', $env);

	echo "DB Connection (mysql, pgsql, mariadb, sqlite) [mysql]: ";
	$dbConn = trim(fgets(STDIN)) ?: 'mysql';

	$defaultPort = '3306';
	$defaultUser = 'root';

	if ($dbConn === 'pgsql') {
		$defaultPort = '5432';
		$defaultUser = 'postgres';
	}

	echo "DB Host [127.0.0.1]: ";
	$dbHost = trim(fgets(STDIN)) ?: '127.0.0.1';

	echo "DB Port [$defaultPort]: ";
	$dbPort = trim(fgets(STDIN)) ?: $defaultPort;

	echo "DB Name [solaris]: ";
	$dbName = trim(fgets(STDIN)) ?: 'solaris';

	echo "DB Username [$defaultUser]: ";
	$dbUser = trim(fgets(STDIN)) ?: $defaultUser;

	echo "DB Password: ";
	$dbPass = trim(fgets(STDIN));

	$env = preg_replace('/DB_CONNECTION=.*/', "DB_CONNECTION=$dbConn", $env);
	$env = preg_replace('/DB_HOST=.*/', "DB_HOST=$dbHost", $env);
	$env = preg_replace('/DB_PORT=.*/', "DB_PORT=$dbPort", $env);
	$env = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$dbName", $env);
	$env = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME=$dbUser", $env);
	$env = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD=$dbPass", $env);

	file_put_contents('.env', $env);
}

function run($command) {
	echo "Running: $command\n";
	passthru($command);
}

run('composer install --no-dev --optimize-autoloader');
run('npm install');
run('php artisan key:generate --ansi');
run('php artisan reverb:install -q -n');

str_replace('BROADCAST_CONNECTION=log', 'BROADCAST_CONNECTION=reverb', file_get_contents('.env'));

echo "Run migrations and seeders? (y/n) [y]: ";
$runMigrate = trim(fgets(STDIN));
if (strtolower($runMigrate) !== 'n') {
	run('php artisan migrate --force');
	run('php artisan db:seed --class=SolarisSeeder --force');
}

run('php artisan optimize');

echo "\n--- INSTALLATION COMPLETE ---\n";
echo "Please run the server using high-level commands:\n";
echo "- npm run web    : Starts the web server\n";
echo "- npm run worker : Starts the queue worker\n";
echo "- npm run full   : Starts everything (web + worker)\n\n";
