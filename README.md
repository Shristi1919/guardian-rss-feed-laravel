# Guardian RSS Feed - Laravel Project

This project is a simple Laravel-based application that fetches and serves RSS feeds from The Guardian's various sections. The application uses The Guardian API to retrieve articles for a specified section and converts the data into an RSS format for use in RSS readers or other applications.

## Features

- Fetches RSS feeds from The Guardian API for various sections (e.g., Politics, Life and Style, Sports, etc.).
- Validates section names to ensure only valid lowercase and hyphenated sections are accepted.
- Caches the RSS feed data for 10 minutes to improve performance and reduce API calls.
- Provides error handling for invalid section names, API failures, and empty results.

## Requirements

- PHP 8.2.0 or higher
- Laravel 11.x or higher
- Composer
- Cache driver (e.g., Redis, Memcached, or File)
- API key from [The Guardian API](https://open-platform.theguardian.com/documentation/)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/guardian-rss-feed-laravel.git
2. Install the dependencies:

    ```bash
    composer install


## API Endpoints

The application provides an endpoint to fetch RSS feeds from The Guardian's API for different sections. The endpoint is as follows:

### Get RSS Feed for a Specific Section

- **Endpoint**:  `/rssfeed/{section}`
- **Method**: `GET`
- **Parameters**: 
  - `{section}`: The section name for which you want to fetch the RSS feed. The section name must be in lowercase and can include hyphens (e.g., `lifeandstyle`, `politics`).


### Example

To fetch the RSS feed for a specific section, replace `{section}` with the desired section name. For example:

- `/rssfeed/politics`
- `/rssfeed/lifeandstyle`
Make sure to use lowercase letters and hyphens for the section names.


## Running Tests with PHP Artisan

To run the tests for the application, use the following command:

1. **Run All Tests**:  
   This will run all the tests in the application:
   ```bash
   php artisan test

 ## Screenshots
 1. Screenshot of Politics
![Screenshot](https://github.com/Shristi1919/guardian-rss-feed-laravel/blob/main/public/Screenshots/politics.png)

2. Screenshot of Life and Style
![Screenshot](https://github.com/Shristi1919/guardian-rss-feed-laravel/blob/main/public/Screenshots/lifeandstyle.png)

3. Screenshot of Invalid Section
![Screenshot](https://github.com/Shristi1919/guardian-rss-feed-laravel/blob/main/public/Screenshots/invalid-section.png)

4. Screenshot of Invalid Section Name Error Response
![Screenshot](https://github.com/Shristi1919/guardian-rss-feed-laravel/blob/main/public/Screenshots/errorsection.png)

5. Screenshot of Test Case
![Screenshot](https://github.com/Shristi1919/guardian-rss-feed-laravel/blob/main/public/Screenshots/testcase.png)
