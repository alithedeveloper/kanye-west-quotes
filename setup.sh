echo "Installing PHP dependencies via Composer..."
composer install

echo "Copying .env file..."
cp .env.example .env

echo "Generating application key..."
php artisan key:generate

# Check if you want to use sqlite
read -p "Do you want to use SQLite as your database? (y/n) " -n 1 -r
echo    # move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    echo "Setting up SQLite..."
    touch database/database.sqlite
    php artisan migrate
fi

echo "Clearing the cache, config and views etc..."
composer run clear

# Run the tests
echo "Running the tests..."
php artisan test

read -p "Do you want to run the server? (y/n) " -n 1 -r
echo    # move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    echo "Running the server..."
    php artisan serve
fi
