# class.ipv4.php
A php class to calculate subnet, Interesting octet, valid hosts, subnet to cidr, cidr to subnet, Ip class , Network id and etc.
## How to use 
1) Include the class file.
```php
require_once('class.ipv4.php');
```
2) Create an object of the class.
```php
$Obj = new Ipv4();
```
3) Access methods via object.
```php
$Obj->set_ip_address(array $value);
```
## Methods 
### Setting values
1) To set the ip address
```php
set_ip_address(array $value);
```
2) To set subnet mask*
```php
set_subnet_mask(array $value);
```
3) To set cidr value*
```php
set_cidr_value(array $value);
```

Note: Setting up subnet mask automatically set up the cidr and viz.
### Getting values
1) To get the ip address
```php
get_ip_address();
```
> Return type is array
2) To get the subnet mask
```php
get_subnet_mask();
```
> Return type is array
3) To get cidr value
```php
get_cider_value();
```
4) To get IP class
```php
get_ip_class_value();
```
5) To get interesting octet 
```php
get_interesting_octet();
```
6) To get valid host range
```php
get_valid_hosts();
```
