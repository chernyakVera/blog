# blog
For the blog to work correctly, you need to create 4 tables in the database phpMyAdmin:

  1st table - `articles` with columns:
    `id` (int, AUTO_INCREMENT) - this is primary and index with table `comments`, 
    `author_id` (int), 
    `name` (varchar 255, utf8_general_ci),
    `text` (text, utf8_general_ci),
    `created_at` (datetime, CURRENT_TIMESTAMP, DEFAULT_GENERATED).
    
    2nd table - `comments` with columns:
      `id` (int, AUTO_INCREMENT),
      `user_id` (int),
      `article_id` (int) - this is index with table `articles`,
      `text` (varchar 255, utf8_general_ci),
      `created_at` (datetime, CURRENT_TIMESTAMP, DEFAULT_GENERATED).
      
    3d table -  `users` with columns:
      `id` (int, AUTO_INCREMENT),
      `nickname` (varchar 128, utf8_general_ci),
      `email` (varchar 255, utf8_general_ci),
      `is_confirmed` (tinyint 1),
      `role` (enum ('admin', 'user'), utf8_general_ci),
      `user_pic` (varchar 255, utf8_general_ci),
      `password_hash` (varchar 255, utf8_general_ci),
      `auth_token` (varchar 255, utf8_general_ci),
      `created_at` (datetime, CURRENT_TIMESTAMP, DEFAULT_GENERATED).
      
    4th  table - `users_activation_cods` with columns:
      `id` (int, AUTO_INCREMENT),
      `user_id` (int),
      `code` (varchar 255, utf8_general_ci).
