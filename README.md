1-Install node y composer
2-Install xampp
3-Create database called laravel_master
4-import sql from laravel_master
5-save project to hdocs xampp with folder name as is
6- Create a virtual host
The route of the xampp is C:\xampp\apache\conf\extra and change the httpd-vhost
   
<VirtualHost *:80>   
    DocumentRoot "C:/xampp/htdocs/PI_FTC/social-app/public"
    ServerName social-app.com.devel
    ServerAlias www.social-app.com.devel
    <Directory "C:/xampp/htdocs/PI_FTC/social-app/public">
        Options Indexes FollowSymLinks     
        AllowOverride All
        Order Deny,Allow
        Allow from all     
    </Directory> 
</VirtualHost>
--------------------------------------------------------------------------------------
And on hosts put without the # this by following the steps below described : 
127.0.0.1     social-app.com.devel

1- Open the notepad as ADMINISTRATOR, and from it open the hosts file
2- turn the xampp off and on
3-Then in the search engine, http://social-app.com.devel/ with http:// to make it work.
4-To run the project in terminal 
cd command C: xampp htdocs PI_FTC social-app and then npm run dev in terminal looking for the social app file
5- Configure the . env with mailtrap apis to recover password and pusher for sending chat messages. 
Create your own account to get your own keys in https://mailtrap.io/es/ and in https://pusher.com/ to use the 2 apis that laravel uses.
