# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.2] - 2020/04/24

## Changed

- Will have the ability to pass query options to SegmentManager->getItems()

## [1.1.1] - 2019/15/05

## Changed

- Will avoid calling Authentication in the constructor

## [1.0.3] - 2018/11/05

## Changed

- Properly manage date times during entity hydration

## [1.0.2] - 2018/10/31

## Added

- Unified Taxonomy Labels Ids for segments (create / update /read)

## [1.0.1] - 2018/10/31

## Added

- more tests to various parts of the library

## Changed

- Some entity getter/setter types

# [1.0.0] - 2018/10/30

## Changed

- Platform requirement PHP >= 7.1
- `Audiens\AdForm\Provider\*Provider` => `Audiens\AdForm\Manager\*Manager`
- Updated the requirements to their latest versions
- Updated PHPUnit to v7.4
- Strict types across all the library
