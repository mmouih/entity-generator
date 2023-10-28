# Payload Entity Generator

The **Payload Entity Generator** is a tool designed to streamline the conversion of JSON payloads into class entities for PHP applications running on PHP 7 and beyond.
The generated entities adhere to the PSR-12 coding standards, ensuring a clean and consistent codebase.

This tool is particularly valuable for swiftly transforming payloads into Data Transfer Objects (DTOs), enhancing your PHP application's flexibility and efficiency.

## Requirements

- **PHP 8.2** or higher

## Usage

To leverage the **Payload Entity Generator**, use the following command:

### Using Json file
```shell
./app generate [EntityName] [Payload] --f
```
### Using Json string
```shell
./app generate [EntityName] [Json] "json" 
```
Or simply 
```shell
./app generate [EntityName] [Json]
```

Exemple: 
```shell
./app generate User '{"id": 1, "label": "john"}'
```

### Using XML file
```shell
./app generate [EntityName] [filepath] "xml" -f
```

### Using XML string
```shell
./app generate [EntityName] [XML] "xml" 
```

### Using Yaml file
```shell
./app generate [EntityName] [filepath] "xml" -f
```