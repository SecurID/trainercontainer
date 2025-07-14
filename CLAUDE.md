# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a **Laravel 12** application for sports trainers to manage players, practices, exercises, and ratings. It's designed as a training management system with features for player performance tracking and practice organization.

## Technology Stack

- **Backend**: Laravel 12 (PHP 8.4+)
- **Frontend**: Livewire 3, TailwindCSS, Vue.js components
- **Authentication**: Laravel Jetstream with Sanctum
- **Database**: SQLite (default), MySQL support
- **Testing**: Pest PHP
- **Build**: Vite with Laravel plugin
- **UI Framework**: Flowbite components
- **SoccerDraw**: There is a vue app installed which is a drawing tool for soccer exercises. Ignore it until changes to it are explicitly required

## Core Architecture

### Key Models & Relationships
- **User**: Trainers who manage players and practices
- **Player**: Athletes with ratings and practice attendance (`belongsTo User`)
- **Practice**: Training sessions with schedules and ratings (`hasMany Schedule`)
- **Rating**: Player performance scores with attendance tracking (`belongsTo Player, Practice`)
- **Exercise**: Training exercises with categories
- **Schedule**: Practice time slots and planning

### Livewire Components
The application heavily uses Livewire for interactive forms:
- `CreatePlayer` - Player registration form
- `CreatePractice` - Practice scheduling
- `CreateRating` - Player rating system
- `PlayerPracticeRating` - Rating interface for practices
- `PracticeRatingsTable` - Ratings data display

## Common Development Commands

### Laravel/PHP Commands
```bash
No Server needs to be started as Laravel Herd is running in the background

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate application key
php artisan key:generate

# Run tests
./vendor/bin/pest
```

### Frontend Commands
```bash
# Install dependencies
npm install

# Development build with hot reload
npm run dev

# Production build
npm run build
```

### Database Commands
```bash
# Create migration
php artisan make:migration create_table_name

# Create model with migration and factory
php artisan make:model ModelName -mf

# Rollback migrations
php artisan migrate:rollback
```

## Application Structure

### Database Schema
- Uses SQLite for development (see `database/database.sqlite`)
- Key tables: users, players, practices, ratings, exercises, categories, schedules
- Recent addition: `attended` boolean field in ratings table for attendance tracking

### Authentication & Authorization
- Multi-tenant: Each user (trainer) manages their own players and practices
- Jetstream provides team management capabilities
- All routes protected with `auth:sanctum` middleware

### Localization
- Supports German (`de`) and English (`en`)
- Language files in `resources/lang/`
- Uses `SetLocale` middleware

### File Organization
- Controllers follow resource pattern (`PlayerController`, `PracticeController`)
- Livewire components for forms and interactive elements
- Blade templates with component-based architecture
- PDF generation for practice sheets using Spatie/laravel-pdf

## Development Workflow

1. **Database Changes**: Always create migrations for schema changes
2. **New Features**: Consider Livewire components for interactive functionality
3. **Styling**: Use TailwindCSS classes, custom soccer-themed colors available
4. **Testing**: Write Pest tests in `tests/Feature/` and `tests/Unit/`
5. **Internationalization**: Add translations to both language files when adding text

## Special Features

- **PDF Export**: Practice sheets can be exported as PDFs
- **Rating System**: Numeric ratings (1-10) with attendance tracking
- **Practice Scheduling**: Recurring practice support with schedule management
- **Player Analytics**: Performance tracking over time with chart visualization

## Error Handling & Logging

- Uses Laravel's built-in error handling
- Sentry integration configured for production error tracking
- Flash messages for user feedback via session

## Deployment Notes

- Uses Sidecar with Browsershot for PDF generation (requires Puppeteer)
- Environment variables configured for various services (mail, cache, queue)
- Supports Docker deployment (Dockerfile present)

# Styleguide
Apply this styleguide to every newly created component

```bash
// TrainerContainer Color Palette
// Primary Colors - Teal theme from logo
primary-50: #f0fdfa
primary-100: #ccfbf1
primary-200: #99f6e4
primary-300: #5eead4
primary-400: #2dd4bf
primary-500: #14b8a6  // Main brand color
primary-600: #0d9488
primary-700: #0f766e
primary-800: #115e59
primary-900: #134e4a

// Neutral Colors - Grays for UI
gray-50: #f9fafb
gray-100: #f3f4f6
gray-200: #e5e7eb
gray-300: #d1d5db
gray-400: #9ca3af
gray-500: #6b7280
gray-600: #4b5563
gray-700: #374151
gray-800: #1f2937
gray-900: #111827

// Accent Colors
success-green: #10b981
warning-amber: #f59e0b
error-red: #ef4444
info-blue: #3b82f6

// Background Colors
bg-primary: #ffffff
bg-secondary: #f9fafb
bg-tertiary: #f3f4f6
bg-dark: #111827

// Text Colors
text-primary: #111827
text-secondary: #4b5563
text-tertiary: #6b7280
text-inverse: #ffffff

// Border Colors
border-light: #e5e7eb
border-default: #d1d5db
border-dark: #9ca3af

// Shadow Colors
shadow-sm: rgba(0, 0, 0, 0.05)
shadow-md: rgba(0, 0, 0, 0.1)
shadow-lg: rgba(0, 0, 0, 0.15)

// Special Effects
gradient-start: #14b8a6
gradient-middle: #0d9488
gradient-end: #0f766e
overlay-light: rgba(255, 255, 255, 0.9)
overlay-dark: rgba(0, 0, 0, 0.5)
```

