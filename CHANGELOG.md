# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- CLI support multy echo using prints(), and new line & tabs)
- MyPDO support new constructor with static function

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
