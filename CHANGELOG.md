# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 2024-05-22
### Added
- added mail config.

## [1.1.0-beta.2] - 2024-05-16
### Added
- Added view file config.

### Changed
- Changed `ViewServiceProvider::class` behavior container register, added `TemplatorFinder::class` container, and add vite manifest asset checks (#14).

## [1.1.0-beta.1] - 2024-04-30
### Added
- Added Terminate function in application bootstrap.
- Added support maintenance mode using Commands.
- Added `Handler::class` for resive error report.
- Added More error page 400, 401, 403, 429, 500.

## [1.0.0] - 2024-03-23
### Changed
- Changed welcome page (support darkmode).
- Changed clean `Services::class`.
- Changed `Storage` folder structur include default application page.

### Removed
- Removed unuse js file

### Fixed
- Still showing header information in json data when sending api service.

### Added
- Added 503 error page.
- Added maintenance mode detection.

## [1.0.0-beta.10] - 2024-03-17
### Changed
- Changed `Model` insted of `MyModel` and `MyCrud`.
- Changed `ApiController` repalce api was deprecated (`Response::header`).
- Changed test strategy, use integrate test case.

## [1.0.0-beta.9] - 2024-02-11
### Changed
- Changed template use latest templator syntax (required dolar sighn).

## [1.0.0-beta.8] - 2024-01-24
### Fixed
- Fixed build path (vite) start with '/'.

### Changed
- Changed use non develop version (sonyprdana/php-library).

## [1.0.0-beta.7] - 2023-12-21
### Changed
- Update Vite vertion 5.
- Change default env file for applicaation and database name.

## [1.0.0-beta.6] - 2023-12-14
### Added
- Added `ViewCommand::class` for clear and compile templator files.

## [1.0.0-beta.5] - 2023-10-30
### Changed
- Change class name of `CommandMap`.
- Refactor command mapper to newst pattern.

## [1.0.0-beta.4] - 2023-10-19
### Fixed
- Fixed typo class name.

## [1.0.0-beta.3] - 2023-08-24
### Added
- Added seed command integration.
### Fixed
- Fixed depreceted render view instead using view

## [1.0.0-beta.2] - 2023-08-15
### Fixed
- Migration path not same with migration folder.

## [1.0.0-beta.1] - 2023-08-14
### Added
- Added `flip/whoops` for handle error message.
- Added Database Provider.
- Supported integrate commands (php-mvc).

### Changed
- New autoload strategy.
- Updated stub file.
- Used parent Karnel (extends).
- Used `view` to render template (costumize).
- Log cron command using costume interface.
- Using new statregy to run miggration command.
- Used `vite` as frontend developement.

## [0.2.1] - 2021-08-13
### Added
- Add ```Request::class``` to handle request
- Add ```Response::class``` to handle response
- global funtion path add optional to add surfix path

### Removed
- Remove ```\Helper\Http\Request::class```
- Remove ```\Helper\Http\Response::class```

### Changed
- ```Serice::class``` using ```Response::class``` for handle output
- ```ServicesController::class``` using ```Response::class``` and ```Response::class``` for handle api request

## [0.2.0] - 2021-07-18
### Changed
- Split the repository, the framework repository (this repo) and the core code
- Make this framework (core code) update able

## [0.1.6] - 2021-06-25
### Added
- Add global some function:
  - app_path, model_path, view_path, controllers_path, services_path, commands_path, cache_path, config_path, base_path
  - startsWith, dd, abort, api_abort, view
  - now -> to manage timing
- Better chain code in cron shedule
- Add command cron:list to show all cron register
- Add make:command to create command class

### Changed
- Help command now create by every single command child class
- Change file from MakerCommand.php to MakeCommand.php
- Rename file from Schadule.php to Schedule.php
- Change namespace from System\App to System\Console
- Command registration now on command.config.php

## [0.1.5] - 2021-05-21
### Added
- MyQuery -> update support add mulity values using single function
- MyModel support costume join table, singel result
- Router support group prefix

### Changed
- MyQuery change function name from conn() to from()
- Change class name from Route to Router

### Fixed
- MyQuery -> insert, remove var_dump() in production
- Mymodel -> cant add value 0 (zero)
- Mymodel -> remove where statment if no bind query
- Fix MyModel prefix ambigus column name, support costume prefix

## [0.1.4] - 2021-04-23
### Added
- Support single cron job to handle all schadule
- Model support static function

### Changed
- Changed regester command from config file to CLI class (/app/core/CLI.php)

## [0.1.3] - 2021-04-16
### Added
- CLI support multy echo using prints(), and new line & tabs)
- CLI make model, auto create property base on table column
- MyPDO support static function and singleton

### Fixed
- CLI make:model/models not replace table name and/or table entry (columns)
- CLI make:models class name not same with file name
- Services handle class funtion if not return as array (default is empty array)

## [0.1.2] - 2021-03-21
### Added
- Support default services respone for API
- MyQuery Support static function
- Add command to serve app using cli
- Coloring cli (partial)

### Changed
- MyQuery Insert values now using associative array
- Home page / Welcome page more staylis


## [0.1.1] - 2021-02-05
### Added
- Add setup.sh, short hand to setup project

### Changed
- Refactory MyQuery

## [0.1.0] - 2021-01-28
### Added
- Project init
- Model/models grap database data
- Query bulider
- view, controller and services
- MVC structur
- cli, router, and more
