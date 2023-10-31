# Entity Generator

The **Entity Generator** is a tool designed to streamline the conversion of payloads into class entities for PHP applications running on PHP 7 and beyond.
The generated entities adhere to the PSR-12 coding standards, ensuring a clean and consistent codebase.

This tool is particularly valuable for swiftly transforming payloads into Data Transfer Objects (DTOs), enhancing your PHP application's flexibility and efficiency.

## Requirements

- **PHP 8.2** or higher

## Usage

To leverage the **Entity Generator**, use the following command:

### Using Json file
```shell
./phpgen generate [EntityName] [Payload] --f
```
### Using Json string
```shell
./phpgen generate [EntityName] [Json] "json" 
```
Or simply 
```shell
./phpgen generate [EntityName] [Json]
```

Example: 
```shell
./phpgen generate User '{"id": 1, "label": "john"}'
```

### Using XML file
```shell
./phpgen generate [EntityName] [filepath] "xml" -f
```

### Using XML string
```shell
./phpgen generate [EntityName] [XML] "xml" 
```

### Using Yaml file
```shell
./phpgen generate [EntityName] [filepath] "xml" -f
```

## Configuration file

You can use customized entity generation options using a configuration a below,

```yaml
#config.yaml.dist
entity.generator:
    output.dir: 'var/generated'
    namespace: 'Entity\Generated'
    property.phpdoc: true
    property.type: true # false before php7.4
```

```shell
./phpgen generate [EntityName] [filepath] "xml" -f -c path/to/config.yaml.dist
```

If config file is not configured, default options `(config.yaml.dist)` will be used.