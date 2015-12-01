# Guru Digital SilverStripe Extensions

A collection of handy extensions, page types, models and modules.

## Work in progress

This module is work in progress and is still being regularly refactored. Until version 1.0 the API is likely to change

## Requirements <sub>*(Installed automatically when using [Composer](https://getcomposer.org/))*</sub>
 * [SilverStripe](http://www.silverstripe.org/) ^3.1
 * [silverstripe-australia/gridfieldextensions](https://github.com/silverstripe-australia/silverstripe-gridfieldextensions) ^1
 * [colymba/gridfield-bulk-editing-tools](https://github.com/colymba/GridFieldBulkEditingTools) ^2.1
 * [sheadawson/silverstripe-linkable](https://github.com/sheadawson/silverstripe-linkable) ^1.0
 * [unclecheese/betterbuttons](https://github.com/unclecheese/silverstripe-gridfield-betterbuttons) ^1.2

## Installation
```shell
composer require gdmedia/silverstripe-gdm-extensions
```
or download the [The zip](https://github.com/guru-digital/ss-gdm-extensions/archive/master.zip) then extract and rename  `ss-gdm-extensions-master` to `silverstripe-gdm-extensions`

## License
3-clause BSD license
See [License](license.md)

## Documentation
ToDo

####Extended classes
 * **ContentController** *via [SSGuru_ContentController](code/Extensions/SSGuru_ContentController.php)*
   Added features
   Additional the methods.....
 * **Controller** *via [SSGuru_Controller](code/Extensions/SSGuru_Controller.php)*
   Added features
   Additional the methods.....
 * **ErrorPage** *via [SSGuru_ErrorPage](code/Extensions/SSGuru_ErrorPage.php)*
   Added features
   Additional the methods.....
 * **PageUtilities** *via [SSGuru_PageUtilities](code/Extensions/SSGuru_PageUtilities.php)*
   Added features
   Additional the methods.....
 * **SiteTree** *via [SSGuru_SiteTree](code/Extensions/SSGuru_SiteTree.php)*
   Added features
   Additional the methods.....
 * **ViewableData** *via [SSGuru_ViewableData](code/Extensions/SSGuru_ViewableData.php)*
   Added features
   Additional the methods.....

## Configuration
`ContentController`, `Controller`, `ErrorPage`, `PageUtilities`, `SiteTree` and `ViewableData` are extended by default via [ss-gdm-extensions/_config/config.yml](_config/config.yml)
```yaml
ContentController:
  extensions:
    - SSGuru_ContentController
Controller:
  extensions:
    - SSGuru_Controller
ErrorPage:
  extensions:
    - SSGuru_ErrorPage
Page:
  extensions:
    - SSGuru_PageUtilities
SiteTree:
  extensions:
    - SSGuru_ViewableData
    - SSGuru_SiteTree
ViewableData:
  extensions:
    - SSGuru_ViewableData
```

Other optional extensions are
* `SSGuru_CarouselPage` - Adds a Carousel to a page type ( Compatible template required )

Add optional extensions in your `mysite/_config/config.yml`
```
YourPageClass:
  extensions:
    - SSGuru_PageExtension
```

## Bug tracker
Bugs are tracked in the issues section of this repository. Before submitting an issue please read over existing issues to ensure yours is unique.

If the issue does look like a new bug:

 - [Create a new issue](issues/new)
 - Describe the steps required to reproduce your issue, and the expected outcome. Unit tests, screenshots  and screencasts can help here.
 - Describe your environment as detailed as possible: SilverStripe version, Browser, PHP version, Operating System, any installed SilverStripe modules.

Please report security issues to the module maintainers directly. Please don't file security issues in the bug tracker.

## Development and contribution
If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.

## Versioning

*Prior to version 1.0.0 breaking changes may occur.*

This project follows [Semantic Versioning](http://semver.org) paradigm. That is:

> Given a version number MAJOR.MINOR.PATCH, increment the:
>  1. MAJOR version when you make incompatible API changes,
>  2. MINOR version when you add functionality in a backwards-compatible manner, and
>  3. PATCH version when you make backwards-compatible bug fixes.
>  4. Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.
