# simple-laravel-react

A simple Laravel/React application for reading and obtaining and displaying content from a web page

## Table of contents

- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Contributing](#contributing)
- [License](#license)

## Installation

1. Clone the repository:
  git clone <https://github.com/benniesm/simple-laravel-react.git>

2. Install PHP dependencies:
  composer install

3. Install JavaScript dependencies:
  npm install

4. Configure the database:

- Create a `database.sqlite` or use a different Database
- Edit the `.env` file
- Run migrations for the database
  php artisan migrate

5. Build the React app:
  npm run dev

6. Start the development server:
  php artisan serve

## Retrieving Links from the URL

Navigate to `[app_url]/create` on your web browser to retrieve article links from the main column of the first page of <https://pinboard.in/u:alasdairw?per_page=120>

## Accessing the application UI

Open the specified app URL in your web browser.
