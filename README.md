phpMs
=====
phpMs is PHP-based free open-source library for proteomics. The library contains a core set of classes for storing common data such as spectra, peptides and proteins. In addition the library contains a number of readers and/or writers for common file formats, including MGF, FASTA, mzIdentML, proBed. The library also contains a number of useful utiltities for performing protein digestion, peptide fragmentation, and search engine intergration.

![Build Status](http://pgb.liv.ac.uk/jenkins/buildStatus/icon?job=php-ms)
![Quality Gate](http://pgb.liv.ac.uk/ci/phpMs/badge/gate.svg)

![Test Success](http://pgb.liv.ac.uk/ci/phpMs/badge/test_success_density.svg)
![Unit Test Coverage](http://pgb.liv.ac.uk/ci/phpMs/badge/coverage.svg)
![SQALE Debt Ratio](http://pgb.liv.ac.uk/ci/phpMs/badge/sqale_debt_ratio.svg)

Requirements
------------
- PHP Version 5.4+
  - ext/xsl

Composer Installation
---------------------

phpMs  can be used with [Composer](https://getcomposer.org/) and is available via [Packagist](https://packagist.org/packages/pgb-liv/php-ms).

    
	"require" : {
		  "pgb-liv/php-ms" : "dev-master"
	},

Git Installation
----------------

For non-composer users or phpMs developers, phpMs source can be pulled directly.

    git clone git://github.com/PGB-LIV/php-ms.git
    composer install

The composer install will add any dependencies required to run tests.

API Documentation
-----------------

The latest version of the API is available at: http://pgb.liv.ac.uk/ci/phpMs/doc/

Usage Examples
--------------

See the [phpMs Demo Suite](http://github.com/PGB-LIV/php-ms-example) for examples of how to use the API. A live demo is also available via http://pgb.liv.ac.uk/phpMs
