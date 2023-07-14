# Changelog

## [Unreleased]

### Added

- Add `hasParameter`, `hasService` and `hasStatic` methods
- Inject container object to service resolver

### Fixed

- Validate not empty identifier is passed

## [0.2.0]

### Added

- Add `static(string $id, mixed $value)` method to `Container` class
- Add `parameter(string $id, mixed $value)` method to `Container` class
- Add `ContainerException` class
- Add `NotFoundException` class

### Changed

- Changed `EntryNotFoundException` parent from `\InvalidArgumentException` to `NotFoundException`

[Unreleased]: https://github.com/phetit/container/compare/v0.2.0...main

[0.2.0]: https://github.com/phetit/container/compare/v0.1.0...v0.2.0
