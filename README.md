# 3LPIC-website

> This project is a very simple implementation for your project.
Not all code conventions have been followed to save time.

---

## Prerequest

`php8.1^`

`apache` or `nginx` with the php 8 module enabled

`mysql-server` or `mariadb`

## Installation

You just have to clone this repository in your web server root directory.

`git clone https://github.com/TheoPez/3LPIC-website.git`

## Configuration
In order for this site to work properly, you must update the `.env` file to fit your environement

`.env` example:
```.env
# DB Connection
DB_HOST='localhost' # Your database address
DB_USER='root'      # Your database username
DB_PASS='root'      # The password of the above user
DB_NAME='db_coursero' # It's the name of the database (case sensitive)

# Submissions table name
SUBMISSIONS_TABLE='submissions'

# Path for uploaded files
SUBMISSIONS_PATH='/tmp/'

# You can declare two programming language supported for your project
PROGRAMMING_LANGUAGE_1='Python'
PROGRAMMING_LANGUAGE_2='C'
```

## Deploy the database
To deploy the database and migrate the tables, you just have to open the website. At this moment, a script is executed for the deployment if the database and the tables do not exist.

**This is not a normal behavior in normal circumstances but allows to set up your environment much easier for your POC**

Here is what the generated table looks like:
![image](https://user-images.githubusercontent.com/47640901/201532973-9f3b18ad-cfc3-4460-8ae0-c15dcaa6e3b7.png)
