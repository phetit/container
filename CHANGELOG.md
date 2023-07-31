# Changelog

## [Unreleased]

### Changed

- **Breaking:** rename `InvalidTypeException` to `AbstractTypeException`
- **Breaking:** rename `InvalidBuiltinTypeException` to `BuiltinTypeException`
- **Breaking:** rename `InvalidIntersectionTypeException` to `IntersectionTypeException`
- **Breaking:** rename `InvalidMissingTypeException` to `MissingTypeException`
- **Breaking:** rename `InvalidUnionTypeException` to `UnionTypeException`

## [0.7.0] - 2023-07-26

### Added

- Add support for dynamic class resolution
- Auto inject container reference into container

## [0.6.0] - 2023-07-25

### Added

- Add `ContainerBuilder` class
- Add ability to replace existing parameter/service
- Add `Resolver\ServiceResolver` class
- Add `Resolver\FactoryServiceResolver` class

### Changed

- **Breaking:** rename `register()` method to `set()`
- **Breaking:** `register()` now receives `Resolver\ResolverInterface` as second parameter

### Removed

- **Breaking:** remove `factory()` method
- **Breaking:** remove `hasFactory()` method

### Fixed

- Thrown exception when an already registered identifier is being used.

## [0.5.0] - 2023-07-19

### Changed

- **Breaking:** change namespace from `Phetit\Container` to `Phetit\DependencyInjection`
- **Breaking:** rename package from `phetit/container` to `phetit/dependency-injection`

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

[Unreleased]: https://github.com/phetit/dependency-injection/compare/v0.7.0...main
[0.7.0]: https://github.com/phetit/dependency-injection/compare/v0.6.0...v0.7.0
[0.6.0]: https://github.com/phetit/dependency-injection/compare/v0.5.0...v0.6.0
[0.5.0]: https://github.com/phetit/dependency-injection/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/phetit/dependency-injection/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/phetit/dependency-injection/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/phetit/dependency-injection/compare/v0.1.0...v0.2.0
