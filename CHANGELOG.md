# Release 5.0

 * [close #101] - remove ContainerBase class

# Release 4.2

 * [close #92] - contributing file improvements
 * [close #90] - email validation
 * [close #98] - open github pages from bash
 * [close #96] - number as scalar types
 * [close #69] - documentation improvements
 * [close #70] - property become mandatory when a value or array of value
 * [close #71] - remove duplication and set methods as deprecated

# Release 4.1

 * [close #61] - allow global configuration
 * [close #62] - range of values configuration
 * [close #63] - override values configuration
 * [close #80] - show all mandatory fields when one is missed

# Release 4.0

 * introduced documentation for developers
 * removed public static method
 * fixed exception message
 * introduced configurator
 * introduced resources Container class configuration
 * sensorario/value-object is now sensorario/resources
 * forced properties to utf-8 encoding
 * removed code complexity

# Release 3.0

 * [closed #39] - added hasProperties method
 * [closed #35] - contribution must be present in CHANGELOG file
 * [closed #33] - added usages references
 * [closed #34] - added configuration check
 * [closed #27] - fixed metadata
 * [closed #18] - removed if_present condition
 * [closed #21] - removed uncovered code
 * [closed #19] - added coverage script
 * [closed #25] - improved CONTRIBUTING file

# Release 2.2

 * getter throw an exception when property name is an empty string
 * [closed #17] Improved 'when' syntax to set mandatory properties
 * [closed #16] All values that make a property mandatory can be defined as array
 * [closed #15] A Property is allowe also when mandatory depending other values
 * [closed #14] Added new syntax for mandatory values
 * [closed #13] Improved error messages when value is not allowed
 * [closed #12] Improved error messages

# Release 2.1

 * [closed #11] composition of value objects

# Release 2.0

 * [closed #10] completed copyright dockblocks
 * All test are now inside src\Sensorario\Test folder
 * Added README file
 * Introduced Sensorario\ValueObject\Interfaces\Service interface
 * Moved all services inside Sensorario\Helpers namespace
 * Moved all test resources inside Sensorario\Test namespace
 * [closed #8] property could be defined as scalars or as objects
 * [closed #9] right property type must appear in exception message
 * Added conditional mandatory properties
 * Added Validator classes
 * Properties can have a type
 * Check not yet implemented methods
 * Minor fixes and improvements
 * Expose property accessor
 * Adoption of semantic versioning
 * Added a service to export ValueObject in JSON
 * Contraints in values that a property can have
 * Added a list of reserved keywords for public static method
 * Init test suite, written readme file and defined composer required libs
 * Value object must be created throw ValueObject::box() method
 * Method like defaults, mandatory, allowed could define properties of a VO
 * Configured phpdocumentor for documentation
 * Added CONTRIBUTING file
