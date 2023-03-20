<h1>Deploying Steps</h1>

1- clone the repository
2- run "composer update"
3- run "npm install"
4- run "npm run-dev"
5- run "php artisan migrate:fresh --seed"

<p>It will create 100 posts and 5 users</p>

Feel free to register another user and test the posts CRUD

All created users have the password "password", You can use any of the users by checking the database users table, copy the email, and then using the mentioned password

Added bonus points: (Protection againest DDOS attacks with throttle, Used SOLID principles, And social login)

P.S: Facebook needs live environment to get it working but the code is there

Thanks
