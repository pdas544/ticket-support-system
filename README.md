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
5) Routing
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
  <li>Modify Line: 12 in the config file in includes/initialize.php 
    <pre><code>defined('SITE_ROOT') ? null : define('SITE_ROOT','C:'.DS.'xampp'.DS.'htdocs'.DS.'ticket-support-system');</code></pre>
  </li>
  <li>Install dependencies:
    <pre><code>$db = new mysqli("localhost", "DB_USER", "DB_PASSWORD", "ticketing_support");</code></pre>
  </li>
  <li>Create Database and tables in MySQL using MySQL CLI or PHPMyadmin
    <pre><code>DB NAME: ticketing_support</code></pre>
  </li>
</ol>

<h2 style="color:#FF4500;">Usage</h2>
<ol>
  <li>Access the LMS dashboard at <code>http://localhost:8000</code>.</li>
  <li>Create an account or log in as an admin to manage courses and users.</li>
  <li>Explore the learning modules and track progress.</li>
</ol>

