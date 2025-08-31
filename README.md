# Master Data Management (MDM) System

This is a simple **PHP + MySQL application** built as part of the internship practical test.  
The system allows **user authentication** and **CRUD operations** for Brands, Categories, and Items with role-based access control.

---

## 🔹 Features

- **User Authentication**
  - Register, Login, Logout
  - Role-based access (`Admin` vs `User`)

- **Brands**
  - Create, View (with pagination), Edit, Delete
  - Default status = Active

- **Categories**
  - Create, View (with pagination), Edit, Delete
  - Default status = Active

- **Items**
  - Create, View (with pagination), Edit, Delete
  - Upload attachment

- **Admin Role**
  - Can view/manage all users' data

- **Validation**
  - Required fields (code, name, etc.)
  - File upload validation

---

## 🔹 Technologies Used

- **PHP 8+** (plain PHP)
- **MySQL**
- **HTML + CSS (basic styling)**
- **Sessions for authentication**

---

## 🔹 Installation Guide

- **Step-by-step to run locally:**
  - 1. **Clone the repository**
    - git clone https://github.com/janushan12/Master-Data-Management-System.git
    - cd Master-Data-Management-System

  - 2. **Setup Database**
    - **Import mdm_db.sql into MySQL (you should include this file in repo).**
    - **Update db.php with your database credentials.**

  - 3. **Start XAMPP / WAMP and move project to htdocs (if using XAMPP).**
  
  - 4. **Run in browser**
    - **http://localhost/MDM**

  - 5. **Usage**
    - **Register/Login with valid credentials.**
    - **Add categories, brands, and items.**
    - **Use search & filters to find items.**
    - **Logout securely.**