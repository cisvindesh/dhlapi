Overview:
---------
Test tasks for applicants
As a test task, you are invited to create a Drupal module that will interact with the DHL API.
The module should provide a form for entering the country, city and postal code. For example Czechia, Prague, 11000.
After submitting the form, a list of locations should be displayed.
To obtain data, you must send a request to https://api.dhl.com/location-finder.
API documentation is available at: https://developer.dhl.com/api-reference/location-finder
'demo-key' can be used as value for DHL-API-Key header.
From the list of locations, you need to remove those that do not work on weekends.
As well as those that have an odd number in their address.
For example, location 8003-4134591 should be filtered out because address Maximilianstr. 7 odd.
Each location should be output in yaml format.
Example for location 8007-401067103:
---
locationName: Packstation 103
address:
countryCode: DE
postalCode: '01067'
addressLocality: Dresden
streetAddress: Falkenstr. 10
openingHours:
monday: '00:00:00 - 23:59:00'
tuesday: '00:00:00 - 23:59:00'
wednesday: '00:00 - 23:59:00:00'
thursday: '00:00:00 - 23:59:00'
friday: '00:00:00 - 23:59:00'
saturday: '00:00:00 - 23:59:00'
sunday: '00:00:00 - 23:59:00'
Module functionality should be covered by tests.
The code must be formatted according to the requirements https://www.php-fig.org/psr/psr-12/
Php version is 8.x.
Drupal version is 10.x
Please upload the module to the public repository.
Good luck!

Installation and configuration:
-------------------------------
- Installation is as simple as copying the module into your 'modules' directory,
then enabling the module.

- Enable module from http://example.com/admin/modules OR run rush command $ drush en dhlapi 

- Config setting form: http://example.com/admin/config/dhlapi/dhlapiconfig
  - API base url
  - Endpoint
  - API Key
  - API Secret

- DHL location finder form http://example.com/dhlapi-search-form

