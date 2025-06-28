# Development Guidelines for Trainercontainer

This document provides essential information for developers working on the Trainercontainer project.

## Build/Configuration Instructions

### Local Development Setup

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd trainercontainer
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment configuration**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**:
   ```bash
   # Configure your database connection in .env
   php artisan migrate
   php artisan db:seed  # Optional: seed the database with test data
   ```

5. **Start the development server**:
   ```bash
   php artisan serve
   npm run dev  # In a separate terminal for asset compilation
   ```

### Docker Setup

The project includes a Dockerfile for containerized deployment:

1. **Build the Docker image**:
   ```bash
   docker build -t trainercontainer .
   ```

2. **Run the container**:
   ```bash
   docker run -p 8080:8080 trainercontainer
   ```

The Dockerfile is configured to:
- Use PHP 8.4 and Node.js 18 by default
- Install all dependencies
- Compile assets using either Vite or Laravel Mix
- Expose port 8080

## Testing Information

### Testing Configuration

The project uses both PHPUnit and Pest for testing. Tests are configured in `phpunit.xml`:

- **Test database**: Tests use a separate database named `trainercontainer_test`
- **Test environment**: Tests run in the `testing` environment with in-memory drivers for cache, mail, queue, and session

### Running Tests

```bash
# Run all tests
php artisan test

# Run a specific test file
php artisan test tests/Unit/PlayerTest.php

# Run tests with coverage report
php artisan test --coverage
```

### Writing Tests

The project supports one testing style:

1. **Pest style** (recommended for new tests):
   ```php
   <?php
   
   test('home page loads successfully', function () {
       $response = $this->get('/');
       $response->assertStatus(200);
   });
   ```

### Example Test

Here's a simple test for the Player model:

```php
<?php

use App\Models\Player;

test('player full name is correctly formatted', function () {
    // Arrange
    $player = new Player();
    $player->prename = 'John';
    $player->lastname = 'Doe';

    // Act
    $fullName = $player->getFullname();

    // Assert
    expect($fullName)->toBe('John Doe');
});
```

### Test Organization

- **Unit tests**: Located in `tests/Unit/`, test individual components in isolation
- **Feature tests**: Located in `tests/Feature/`, test HTTP endpoints and application features

## Additional Development Information

### Project Structure

This is a Laravel 12 project with the following key components:

- **Authentication**: Uses Laravel Jetstream
- **Frontend**: Uses Livewire for dynamic interfaces
- **Error tracking**: Uses Sentry
- **PDF generation**: Uses Spatie Laravel PDF
- **Localization**: Uses Laravel Lang

### Key Models and Relationships

- **Player**: Has many Ratings
- **Exercise**: Used for training exercises
- **Rating**: Used to track player performance

### Models
- Don't fill out the fillable attribute as all Models are unguarded by default

### Development Workflow

1. Create a feature branch from main
2. Implement changes with tests
3. Run tests to ensure everything passes
4. Submit a pull request

### Debugging

- Laravel Ignition is configured for improved error reporting
- Sentry is integrated for production error tracking

### Performance Considerations

- The application is configured to use Laravel Octane if available, which can significantly improve performance
- Asset compilation is handled by either Vite or Laravel Mix, depending on the configuration
