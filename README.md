# payload-entity-generator
A json payload to class/entity generator for php applications for php 7+.
The generated Entities follows the PSR12 standard.
Usefull to transform payload to Data Transfer Objects on the fly

# Requirements
PHP8.2

# Usage
`./app generate [ModelName] [Payload path or string]`
# Example
use the command below to generate from a test payload file
`./app generate User tests/data/user.json`
or 
`make poc` to execute the demo