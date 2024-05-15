## Kanye Quotes API

### Overview

This project provides an API for retrieving and managing quotes from Kanye West. The API is secured with api-token based
authentication and features endpoints for fetching random quotes and refreshing them. It integrates external API data
and ensures consistent response structures through a custom Response class.

### Clone the Repository
You can clone the repository by running the following command in your terminal:

```bash
git clone git@github.com:alithedeveloper/kanye-west-quotes.git
cd kanye-west-quotes
```

##  Project Setup

This project includes a bash script named `setup.sh` that automates the setup process for the Kanye Quotes API. This
script helps to streamline the initial configuration and installation steps required to get the project running on your
local machine.

### What the Script Does

The `setup.sh` script performs the following actions:

1. **Installs Dependencies**: Uses Composer to install all required PHP dependencies.
2. **Environment Setup**: Copies the `.env.example` file to `.env` and generates a unique application key using
   Laravel's artisan command.
3. **Database Setup**: Quickly creates a new SQLite database for local development and runs the default migrations.
4. **Clearing cache, config etc**: Runs composer script clear to clear cache, config etc.
5. **Running the tests**: Runs the tests to ensure everything is working as expected.
6. **Starting the server**: Starts the Laravel development server to make the API accessible.

### Prerequisites

Before running the script, ensure you have the following installed:

- PHP 8.2 or higher
- Composer

### Running the Script

To run the `setup.sh` script, follow these steps:

1. **Open your terminal** and navigate to the directory where you want to clone the repository.
2. **Run the script** by entering the following command:

   ```bash
    chmod +x setup.sh
    ./setup.sh
    ```

### Features

#### Quotes Retrieval Endpoint

- **Endpoint**: `/api/quotes`
- **Functionality**: Returns a JSON response containing 5 random Kanye West quotes fetched either from an external API
  or from the cache depending on the cache configuration
- **Implementation**:
    - A `QuotesController` handles the requests to this endpoint.
    - A custom `Response` class formats the JSON responses consistently, including data, message and status code.
    - The endpoint is registered in `routes/api.php`.

#### Integration Tests

- **Location**: Tests are organized under `tests/Integrations` to differentiate from unit tests.
- **Coverage**: Tests cover the actual REST API endpoints by making HTTP requests and verifying responses to ensure they
  meet expected formats and data. If you would like to run the tests, you can do so by running `php artisan test`
  or `composer run test`. If you would like to exclude the integration tests, you can do so by
  running `php artisan test --exclude-group integration` or  `composer test:exclude-integration`.

#### API Routes, Middleware, and Tests

- **API Routes**: All API-related routes are centralized in `routes/api.php` for better management.
- **Middleware**: Implemented `EnsureApiTokenIsValid` middleware to secure API endpoints. Only requests with a valid API
  token are allowed access.
- **Feature Tests**:
    - Located in `tests/Feature`.
    - Tests ensure that unauthenticated requests are rejected and that responses from the Quotes API are as expected.
    - Integration with a mocked Quotes API to validate response structures and data without actual API calls.
- **Configuration**: There is a `config/kanye.php` file for all settings related to the Kanye Quotes API, ensuring easy
  management and configuration.

#### Refresh Quotes Logic

- **Functionality**: Provides an endpoint `/api/quotes/refresh` that allows users to refresh the cached quotes.
- **Details**:
    - The `RefreshQuotesController` handles the cache invalidation and fetches new quotes through the `QuoteManager`.
    - Appropriate tests ensure the functionality works as expected, checking both cache operations and the fetching of
      new data.

## Future Improvements

While the current implementation of the Kanye Quotes API serves its purpose well, there are several enhancements that could further refine the user experience and improve security and performance. Given more time and resources, the following improvements could be pursued:

### Security Enhancements

#### Encrypt and Decrypt the Access Token
- **Goal**: Enhance the security of our API by implementing encryption on the access tokens used for authentication. This would prevent the tokens from being useful to an attacker if intercepted.
- **Approach**: Implement JWT (JSON Web Tokens) or Sanctum to handle the token encryption and decryption seamlessly.

### API Functionality

#### Dynamic Quote Refreshing
- **Goal**: Provide users with the ability to refresh quotes dynamically through the API endpoint without needing to hit a separate endpoint.
- **Approach**: Modify the `/api/quotes` endpoint to accept a `refresh` query parameter (e.g., `/api/quotes?refresh=true`). This parameter would trigger the cache to refresh, pulling new quotes as requested.

### Response Flexibility

#### Enhance the Custom Response Class
- **Goal**: Make the custom Response class more flexible, allowing it to handle various types of content and support more complex API response scenarios.
- **Approach**: Refactor the Response class to support different content types and structures, possibly integrating advanced serialization techniques or adopting a strategy pattern to handle various response formats.

### Monitoring and Logging

#### Enhanced Monitoring and Logging Capabilities
- **Goal**: Improve the ability to monitor API usage and diagnose issues through better logging and monitoring tools.
- **Approach**: Integrate a comprehensive logging framework like Monolog (already supported by Laravel) and consider external monitoring services like New Relic or Sentry for real-time performance and error tracking.




