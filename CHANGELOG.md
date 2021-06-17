# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Global function

### Changed
- Help command now create by every single command child class
- Change file from MakerCommand.php to MakeCommand.php

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
