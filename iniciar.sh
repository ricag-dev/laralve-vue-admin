composer install
npm install
./vendor/bin/sail up -d
./vendor/bin/sail artisan storage:link
./vendor/bin/sail artisan migrate
./vendor/bin/sail composer install
./vendor/bin/sail npm run dev
