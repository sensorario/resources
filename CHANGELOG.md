# Release 2.1.0

 * [closed #11] composition of value objects

# Release 2.0.0

 * [closed #10] completed copyright dockblocks
 * [enhancement] all test are now inside src\Sensorario\Test folder
 * [enhancement] added README file
 * [enhancement] introduced Sensorario\ValueObject\Interfaces\Service interface

## Breaking changes

 * Moved all services inside Sensorario\Helpers namespace
 * Moved all test resources inside Sensorario\Test namespace

# Release 1.1.0

 * [closed #8] property could be defined as scalars or as objects
 * [closed #9] right property type must appear in exception message

# Release 1.0.0

 * Added conditional mandatory properties
 * Added Validator classes
 * Properties can have a type
 * Check not yet implemented methods
 * Minor fixes and improvements
 * Expose property accessor
 * Adoption of semantic versioning
 * Added a service to export ValueObject in JSON
 * Removed some code duplications
 * Removed phpdocumentor support

# Release 0.1.5

 * Removed php 5.4 support
 * Contraints in values that a property can have
 * Removed doc folder, in favour of test suite as documentation
 * Added a list of reserved keywords for public static method

# Release 0.1.4

 * Init test suite, written readme file and defined composer required libs
 * Value object must be created throw ValueObject::box() method
 * Method like defaults, mandatory, allowed could define properties of a VO
 * Configured phpdocumentor for documentation
 * Added CONTRIBUTING file
