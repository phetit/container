# Changelog

## [0.4.0] - 2023-07-14

### Added

- Add `factory` method to register non shared services
- Add `hasFactory` method

### Changed

- Services registered with `register` method now are shared on all calls to `get($id)`

### Removed

- Remove `static` method
- Remove `hasStatic` method

## [0.3.0] - 2023-07-14

### Added

- Add `hasParameter`, `hasService` and `hasStatic` methods
- Inject container object to service resolver

### Fixed

- Validate not empty identifier is passed

## [0.2.0] - 2023-07-13

### Added

- Add `static(string $id, mixed $value)` method to `Container` class
- Add `parameter(string $id, mixed $value)` method to `Container` class
- Add `ContainerException` class
- Add `NotFoundException` class

### Changed

- Changed `EntryNotFoundException` parent from `\InvalidArgumentException` to `NotFoundException`

[Unreleased]: https://github.com/phetit/container/compare/v0.4.0...main
[0.4.0]: https://github.com/phetit/container/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/phetit/container/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/phetit/container/compare/v0.1.0...v0.2.0
