# Ticket Support System
- A portal for management of IT related issues.
- Complete CMS solution for:
  1) User management: Admin can perform CRUD operations on users (normal users and support agents).
  2) Ticket Managment: Functionality for creating new tickets by the user (registered/guest user).
  3) Automatic assignment of tickets to the support agents.
  4) Support Agents can check and update the status of the tickets.
##
**Tech Stack:** PHP, MySQL, Bootstrap
##
**Features**:
1) Server Side Validation
2) Session Management
3) Autoloading of files using Composer
##
**Features being added:**
1) MVC Architecture
2) Single Front Controller (Entry Point of the Application)
3) JWT Authentication using **Sanctum** Library
4) RESTful API
5) Routing using **AltoRouter** Library.
6) Reusing layouts using **Plates** Templating Engine.
## 
**How to use this repo:**
<ol>
  <li>Open Visual Studio Code (OR Any IDE of your choice)  
  </li>
  <li>Open Terminal and go the ROOT of Web Server (C:/xampp/htdocs/) (NOTE: I am using XAMPP)  
  </li>
  <li>Clone the repository:
    <pre><code>git clone https://github.com/pdas544/ticket-support-system.git</code></pre>
  </li>
  <li><strong>Modify Line: 12</strong> in the config file in includes/initialize.php 
    <pre><code>defined('SITE_ROOT') ? null : define('SITE_ROOT','C:'.DS.'xampp'.DS.'htdocs'.DS.'ticket-support-system');</code></pre>
  </li>
  <li><strong>Modify the Line:2</strong>  in the file db.php (parent folder), replace DB_USER, DB_PASSWORD with your own user and password
    <pre><code>$db = new mysqli("localhost", "DB_USER", "DB_PASSWORD", "ticketing_support");</code></pre>
  </li>
   <li>
    Create a new database namely ticketing_support using MySQL CLI or PHPMyadmin.
  </li>
  <li>
    Import the <strong>ticketing_support.sql</strong> in MySQL using MySQL CLI or PHPMyadmin for dummy data.
  </li>
</ol>

<h2 style="color:#FF4500;">Usage</h2>
<ol>
  <li>Start the apache and mysql service (in XAMPP)<code>http://localhost:8000/ticket-support-system</code> </li>
  <li>Homepage displays all the Ticket Stats.</li>
  <li>Use the Navigation Menu Items for necessary actions.</li>
</ol>

