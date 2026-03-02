# Agent Guidelines

## Build, Lint, and Test Commands

### Running Tests

**Run all tests:**
```bash
./vendor/bin/phpunit
```

**Run a specific test class:**
```bash
./vendor/bin/phpunit tests/Feature/ButtonTest.php
```

**Run a specific test method:**
```bash
./vendor/bin/phpunit --filter test_it_can_generate_bootstrap_5_button_group
```

**Run tests with coverage:**
```bash
# Add "coverage" prefix to your commit message or run manually:
./vendor/bin/phpunit --coverage-clover=clover.xml
```

**Run tests with detailed output:**
```bash
./vendor/bin/phpunit --verbose
```

**Run tests in specific suite:**
```bash
./vendor/bin/phpunit --testsuite Test Suite
```

**Run tests with PHPUnit configuration:**
```bash
./vendor/bin/phpunit --configuration phpunit.xml.dist
```

### Code Style and Formatting

**Run PHP CS Fixer (apply fixes):**
```bash
./vendor/bin/php-cs-fixer fix
```

**Check code style without fixing:**
```bash
./vendor/bin/php-cs-fixer fix --dry-run
```

**Enforce coding standards:**
The project uses [PSR-12](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-12-coding-style-guide.md) and [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).

### Editor Config

All files follow [EditorConfig](.editorconfig):
- **Indentation:** 4 spaces
- **Line endings:** LF
- **Charset:** UTF-8
- **Trailing whitespace:** Trimmed

## Code Style Guidelines

### General Conventions

**Imports:**
- Use `use` statements at the top of the file
- Import order: Vendor namespace → Own namespace → Other namespaces
- Use `ord` array syntax (short array with `[]`)
- Remove unused imports
- Sort imports alphabetically

**Type Hints:**
- Always use type hints for function parameters and return values
- Use primitive types: `string`, `int`, `float`, `bool`, `array`
- Use built-in types: `self`, `static`, `callable`, `iterable`, `null`
- For Laravel dependencies, use interface or class names
- Return type declarations should be on separate line

**PHPDoc Comments:**
- Document all public methods
- Include parameter types and descriptions
- Include return type and description
- Use `@param string $name` and `@return bool`
- Single-line PHPDoc for simple cases

**Naming Conventions:**
- **Classes:** PascalCase (e.g., `FormsServiceProvider`)
- **Methods:** camelCase (e.g., `boot()`, `register()`)
- **Properties:** camelCase (e.g., `$showErrors`)
- **Constants:** UPPER_SNAKE_CASE (e.g., `PHP_VERSION_ID`)
- **Booleans:** use `is` prefix (e.g., `hasError()`, `showErrors`)

**Blade Directives:**
- Create directives with `Blade::directive()`
- Format: `Blade::directive('name', function ($parameter) { return '...'; });`
- Always close directives

**Service Providers:**
- Implement `register()` for service registration
- Implement `boot()` for bootstrapping
- Use `$this->app->singleton()` for singleton services
- Use `$this->mergeConfigFrom()` for config merging

**Traits:**
- Use traits for reusable functionality
- Name traits with `Handles` or `With` prefix (e.g., `HandlesValidationErrors`)
- Document trait methods clearly

### Error Handling

**Return booleans from methods:**
- Use `true` for success, `false` for failure
- Document boolean return values in PHPDoc

**Validation errors:**
- Use Laravel's validation methods
- Handle errors via Laravel's error bag system
- Check errors with `hasError()` method

### Testing

**Test Structure:**
- Place feature tests in `tests/Feature/`
- Place unit tests in `tests/Unit/`
- Extend `TestCase` base class
- Use test naming pattern: `test_it_can_do_something()`

**Test Methods:**
- Prefix method name with `test_`
- Use descriptive names describing what is being tested
- Test multiple scenarios if applicable
- Set up framework explicitly in each test

**Test Helpers:**
- Use `$this->setFramework('bootstrap-5')` or `$this->setFramework('material-admin-26')`
- Use `$this->registerTestRoute()` for test routes
- Use `$this->setupFakeMediaDisk()` for media tests

**BrowserKit Testing:**
- Use `visit()` for page navigation
- Use `seeElement()` to verify element presence
- Use `within()` to scope to specific element
- Use `seeInElement()` to check content within element

### Code Organization

**Namespaces:**
- Root namespace: `Javaabu\Forms`
- Support classes: `Javaabu\Forms\Support`
- Http classes: `Javaabu\Forms\Http`
- Commands: `Javaabu\Forms\Commands`
- Tests: `Javaabu\Forms\Tests`

**File Structure:**
- Place related files together
- Use subdirectories for organization (Support, Http, Commands, Views)
- Keep each file focused on a single responsibility

### Laravel Integration

**Laravel Versions:**
- Support Laravel 9-13
- Use Laravel's factory methods and helpers
- Follow Laravel's naming conventions
- Use Laravel's built-in services (config, view, route, etc.)

**Configuration:**
- Define config files in `config/`
- Use `$this->mergeConfigFrom()` in providers
- Support multiple framework options (bootstrap-5, material-admin-26)
- Use environment variables where appropriate

**Blade Components:**
- Register components in `boot()` method
- Use `Blade::componentNamespace()` for component namespace
- Place blade components in `Views/Components/`

## Commit Requirements

- **Add tests!** All changes must include tests
- **One pull request per feature** - send multiple PRs for multiple features
- **Make each commit meaningful** - squash intermediate commits
- **Run linter and tests** - ensure code passes before submitting
- **Follow SemVer v2.0.0** - avoid breaking public APIs
