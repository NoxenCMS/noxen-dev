<?php

namespace app\controllers;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Install extends Controller
{

    
    public function installer(ViewFactory $view)
    {
        
        $noxen_version = "2.1";
        $noxen_author = "Erik Campobadal";
        $noxen_website = "http://noxen.net";
        $mako_website = "http://makoframework.com/";
        $materialize_website = "http://materializecss.com/";
        $author_website = "https://alliberantbits.cat/";
        $urlBuilder = $this->urlBuilder;
        
        $noxen_data = array('noxen_version' => $noxen_version,
                            'noxen_author' => $noxen_author,
                            'noxen_website' => $noxen_website,
                            'mako_website' => $mako_website,
                            'materialize_website' => $materialize_website,
                            'author_website' => $author_website,
                            'urlBuilder' => $urlBuilder,
                           );
        
        return $view->create('install/install', $noxen_data);
    }
    
    public function install(ViewFactory $view)
    {
        
        $rules = 
        [
            'username' => ['required', 'min_length:4', 'max_length:25'],
            'password' => ['required', 'min_length:4'],
            'email'    => ['required', 'email'],
            'repeat_password' => ['required', 'match:"password"'],
            'name' => ['required'],
            'owner' => ['required'],
            'noxen_version' => ['required'],
        ];
        
        $validator = $this->validator->create($this->request->post(), $rules);
        
        if($validator->isValid())
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];
            $app_name = $_POST['name'];
            $app_author = $_POST['owner'];
            $noxen_version = $_POST['noxen_version'];
            
            $db_username = $_POST['db_username'];
            $db_password = $_POST['db_password'];
            $db_name = $_POST['db_name'];
            $db_host = $_POST['db_host'];
            
            
            $path_to_file = 'app/config/database.php';
            $file_contents = file_get_contents($path_to_file);
            $file_contents = str_replace("USERNAME", $db_username, $file_contents);
            $file_contents = str_replace("PASSWORD", $db_password, $file_contents);
            $file_contents = str_replace("DATABASE_HOST", $db_host, $file_contents);
            $file_contents = str_replace("DATABASE_NAME", $db_name, $file_contents);
            file_put_contents($path_to_file,$file_contents);
            
            $urlBuilder = $this->urlBuilder;
            $url = $urlBuilder->to("/install/done?app_author=$app_author&app_name=$app_name&password=$password&username=$username&email=$email&noxen_version=$noxen_version");
            header("Location: $url");
            die();
            
        }
        else
        {
            $errors = $validator->getErrors();
            var_dump($errors);
        }
        
    }
    
    public function done(ViewFactory $view)
    {
        $noxen_version = $_GET['noxen_version'];
        $username = $_GET['username'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $app_name = $_GET['app_name'];
        $app_author = $_GET['app_author'];
        
        if(!$username){
            die("MISSING DATA: Username");
        }
        
        if(!$email){
            die("MISSING DATA: Email");
        }
        
        if(!$password){
            die("MISSING DATA: Password");
        }
        
        if(!$app_name){
            die("MISSING DATA: app_name");
        }
        
        if(!$app_author){
            die("MISSING DATA: app_author");
        }
        
        //INSTALL NOXEN
            
            $connection = $this->database->connection();
            
            $connection->query("CREATE TABLE IF NOT EXISTS `content` (
                                `id` int(11) NOT NULL,
                                  `name` varchar(25) NOT NULL,
                                  `content` text NOT NULL,
                                  `page_id` int(11) NOT NULL
                                ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;");
            
            $connection->query("INSERT INTO `content` (`id`, `name`, `content`, `page_id`) VALUES
(8, 'Title', 'Noxen Demo', 1),
(9, 'Subtitle', 'The CMS for those who were lost', 1),
(10, 'Features1_title', 'Speeds up development', 1),
(11, 'Features2_title', 'User Experience Focused', 1),
(12, 'Features3_title', 'Easy to work with', 1),
(13, 'Features1_content', 'We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.', 1),
(14, 'Features2_content', 'By utilizing elements and principles of Material Design, we were able to create a framework that incorporates components and animations that provide more feedback to users. Additionally, a single underlying responsive system across all platforms allow for a more unified user experience.', 1),
(15, 'Features3_content', 'We have provided detailed documentation as well as specific code examples to help new users get started. We are also always open to feedback and can answer any questions a user may have about Materialize.', 1),
(16, 'Image1_text', 'A modern responsive front-end framework based on Material Design', 1),
(17, 'Image2_text', 'A modern responsive front-end framework based on Material Design', 1),
(18, 'ContactUs_title', 'Contact Us', 1),
(19, 'ContactUs_content', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque id nunc nec volutpat. Etiam pellentesque tristique arcu, non consequat magna fermentum ac. Cras ut ultricies eros. Maecenas eros justo, ullamcorper a sapien id, viverra ultrices eros. Morbi sem neque, posuere et pretium eget, bibendum sollicitudin lacus. Aliquam eleifend sollicitudin diam, eu mattis nisl maximus sed. Nulla imperdiet semper molestie. Morbi massa odio, condimentum sed ipsum ac, gravida ultrices erat. Nullam eget dignissim mauris, non tristique erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;', 1);");
            
            $connection->query("CREATE TABLE IF NOT EXISTS `footer` (
`id` int(11) NOT NULL,
  `title` varchar(25) NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");
            
            $connection->query("INSERT INTO `footer` (`id`, `title`, `bio`) VALUES
(1, 'Noxen Information', 'Noxen by Erik Campobadal is licensed under a Creative Commons Attribution 4.0 International License. To view a copy of this license, visit http://creativecommons.org/licenses/by/4.0/.');");
            
            $connection->query("CREATE TABLE IF NOT EXISTS `groups` (
`id` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `moderator` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            
            $connection->query("INSERT INTO `groups` (`id`, `name`, `moderator`) VALUES
(1, 'admin', 1),
(2, 'user', 0);");
            
            $connection->query("CREATE TABLE IF NOT EXISTS `groups_users` (
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            
            $connection->query("CREATE TABLE IF NOT EXISTS `mail` (
`id` int(11) NOT NULL,
  `type` varchar(75) NOT NULL,
  `from_email` varchar(75) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");
            
            $connection->query("CREATE TABLE IF NOT EXISTS `pages` (
`id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");
            
            $connection->query("INSERT INTO `pages` (`id`, `name`) VALUES
(1, 'Demo Page');");
            
            $connection->query("CREATE TABLE IF NOT EXISTS `posts` (
`id` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(75) NOT NULL,
  `full_text` text NOT NULL,
  `owner` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;");
            
            $connection->query("INSERT INTO `posts` (`id`, `views`, `created_at`, `title`, `full_text`, `owner`) VALUES
(1, 0, '2015-02-08 01:59:40', 'This is a normal post example!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed malesuada nisi. Etiam nibh sapien, convallis sit amet nunc quis, tempor auctor dui. Suspendisse mattis eget mauris eget porttitor. Cras non libero dignissim, tempor sem a, rhoncus urna. Aliquam accumsan leo eu nisl rutrum, quis convallis sapien pretium. Integer efficitur pulvinar urna, vitae porta ligula scelerisque at. Vestibulum finibus ex et erat sollicitudin euismod. Nulla et nunc nisl. Duis id maximus mi, eu vestibulum leo. Ut tincidunt sed ex vel semper. Aenean et sollicitudin lacus. Sed aliquam sem at eros sagittis, id mattis dolor mollis. Integer fringilla molestie ante, vel ornare odio tempor id. Etiam tempor, ante in pharetra cursus, lorem mauris vulputate arcu, tincidunt imperdiet ipsum lectus id nisl. Morbi vitae urna purus.', 'ConsoleTVs'),
(2, 0, '2015-02-08 01:59:45', 'Seems this is the latest post...', 'Donec fermentum quis lectus suscipit gravida. Morbi sit amet pellentesque ipsum. Donec augue orci, cursus ut lectus ac, imperdiet ornare nunc. Aenean metus sapien, luctus sed eros id, bibendum pretium massa. Vestibulum feugiat velit ac dui bibendum tempor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec feugiat erat ac risus tempor, et tincidunt metus accumsan. Aliquam sagittis mollis tortor, nec maximus orci tempus vitae. Nam porttitor diam ipsum, nec pharetra nibh pulvinar id. Aliquam et nulla enim. Curabitur in nisi quis arcu venenatis aliquam sit amet id orci. Proin dignissim elementum ante nec ultricies. Mauris sagittis eros eu lacinia feugiat.', 'ConsoleTVs');");
            
            $connection->query("CREATE TABLE IF NOT EXISTS `settings` (
`id` int(11) NOT NULL,
  `app_name` varchar(25) NOT NULL,
  `app_version` decimal(3,1) NOT NULL,
  `app_author` varchar(50) NOT NULL,
  `maintenance` int(11) NOT NULL,
  `default_user_group` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");
            
            $connection->query("INSERT INTO `settings` (`id`, `app_name`, `app_version`, `app_author`, `maintenance`, `default_user_group`) VALUES
(1, '".$app_name."', '1.0', '".$app_author."', 0, 2);");
            
            $connection->query("CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `action_token` char(64) COLLATE utf8_unicode_ci DEFAULT '',
  `access_token` char(64) COLLATE utf8_unicode_ci DEFAULT '',
  `activated` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `banned` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            
            $connection->query("ALTER TABLE `content`
 ADD PRIMARY KEY (`id`);");
            
            $connection->query("ALTER TABLE `footer`
 ADD PRIMARY KEY (`id`);");
            
            $connection->query("ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);");
            
            $connection->query("ALTER TABLE `groups_users`
 ADD UNIQUE KEY `group_user` (`group_id`,`user_id`), ADD KEY `group_id` (`group_id`), ADD KEY `user_id` (`user_id`);");
            
            $connection->query("ALTER TABLE `mail`
 ADD PRIMARY KEY (`id`);");
            
            $connection->query("ALTER TABLE `pages`
 ADD PRIMARY KEY (`id`);");
            
            $connection->query("ALTER TABLE `posts`
 ADD PRIMARY KEY (`id`);");
            
            $connection->query("ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);");
            
            $connection->query("ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`);");
            
            $connection->query("ALTER TABLE `content`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;");
            
            $connection->query("ALTER TABLE `footer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;");
            
            $connection->query("ALTER TABLE `groups`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;");
            
            $connection->query("ALTER TABLE `mail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;");
            
            $connection->query("ALTER TABLE `pages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;");
            
            $connection->query("ALTER TABLE `posts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;");
            
            $connection->query("ALTER TABLE `settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;");
            
            $connection->query("ALTER TABLE `users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;");
            
            $connection->query("ALTER TABLE `groups_users`
ADD CONSTRAINT `groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;");
            
            $user = $this->gatekeeper->createUser($email, $username, $password, true);
            $name = "admin";
            $groupProvider = $this->gatekeeper->getGroupProvider();
            $group = $groupProvider->getByName($name);
            $group->addUser($user);
            
            $path_to_file = 'app/routing/routes.php';
            $file_contents = file_get_contents($path_to_file);
            $file_contents = str_replace("///*INSTALL", "/*INSTALL", $file_contents);
            $file_contents = str_replace("//*/ENDINSTALL", "ENDINSTALL*/", $file_contents);
            file_put_contents($path_to_file,$file_contents);
            
            echo "<h1>Noxen $noxen_version is now installed</h1><h4>Install routes are now commented to avoid malicious re-installation</h4>";
    }
}